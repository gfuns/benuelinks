<?php
namespace App\Http\Controllers;

use App\Models\PaymentFiles;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class CronController extends Controller
{
    public function validateAccounts()
    {
        $paymentFile = PaymentFiles::where("status", "validating account details")->first();
        if (isset($paymentFile)) {

            $pendingValidation = PaymentHistory::where("file_id", $paymentFile->id)->where("status", "validating account details")->limit(20)->get();

            if (count($pendingValidation) > 0) {

                foreach ($pendingValidation as $pv) {

                    $response = Http::accept('application/json')->withHeaders([
                        'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                    ])->get("https://api.paystack.co/bank/resolve", ["account_number" => $pv->account_number, "bank_code" => $pv->bank_code]);

                    $accountInfo = $response->json();

                    if ($accountInfo["status"] === true) {
                        $bankInfo = $response->collect("data");
                        if (isset($bankInfo["account_name"])) {

                            $response = Http::accept('application/json')->withHeaders([
                                'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                            ])->post("https://api.paystack.co/transferrecipient", [
                                "type"           => "nuban",
                                "name"           => $pv->account_name,
                                "account_number" => $pv->account_number,
                                "bank_code"      => $pv->bank_code,
                                "currency"       => "NGN",
                            ]);

                            $result = $response->json();

                            if ($result["status"] === true) {

                                $data = $response->collect("data");

                                $recipient = $data["recipient_code"];
                                $reference = Uuid::uuid4();

                                $pv->status         = "processing payment";
                                $pv->recipient_code = $recipient;
                                $pv->reference      = $reference;
                                $pv->remark         = "Awaiting gateway response";
                                $pv->save();

                            } else {
                                $pv->status = "payment failed";
                                $pv->remark = "Unable to validate account details";
                                $pv->save();
                            }

                        } else {
                            $pv->status = "payment failed";
                            $pv->remark = "Unable to validate account details";
                            $pv->save();
                        }

                    } else {
                        $pv->status = "payment failed";
                        $pv->remark = "Unable to validate account details";
                        $pv->save();
                    }
                }
            } else {
                $paymentFile->status = "processing payment";
                $paymentFile->save();
            }
        }
    }

    public function initiateBulkTransfer()
    {
        $paymentFile = PaymentFiles::where("status", "processing payment")->first();
        if (isset($paymentFile)) {

            $pendingPayment = PaymentHistory::where("file_id", $paymentFile->id)->where("status", "processing payment")->where("uploaded", 0)->count();

            if ($pendingPayment > 0) {

                // Fetch records from the database
                $beneficiaries = PaymentHistory::where("file_id", $paymentFile->id)->where("status", "processing payment")
                    ->where("uploaded", 0)
                    ->get()->map(function ($beneficiary) use ($paymentFile) {
                    return [
                        'amount'    => round($beneficiary->amount, 2),
                        'reference' => $beneficiary->reference,
                        'reason'    => $beneficiary->narration,
                        'recipient' => $beneficiary->recipient_code,
                    ];
                })->toArray();

                $response = Http::accept('application/json')->withHeaders([
                    'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                ])->post("https://api.paystack.co/transfer/bulk", [
                    'currency'  => "NGN",
                    'source'    => "balance",
                    'transfers' => $beneficiaries,
                ]);

                $responseData = $response->json();

                if ($responseData["status"] === true) {
                    $transferData = $response->collect("data");
                } else {
                    foreach ($beneficiaries as $ben) {
                        $bene         = PaymentHistory::where("reference", $ben["reference"])->first();
                        $bene->status = "payment failed";
                        $bene->remark = "gateway rejected payment";
                        $bene->save();
                    }
                }

                dd($responseData);

            } else {
                $paymentFile->status = "payment data uploaded to gateway";
                $paymentFile->save();
            }
        }
    }
}
