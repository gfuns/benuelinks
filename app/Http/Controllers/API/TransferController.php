<?php
namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\PaymentHistory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class TransferController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('api');
    }

    /**
     * validateBankAccount
     *
     * @param Request request
     *
     * @return void
     */
    public function validateBankAccount($bankCode, $accountNo)
    {
        try {

            $response = Http::accept('application/json')->withHeaders([
                'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
            ])->get("https://api.paystack.co/bank/resolve", ["account_number" => $accountNo, "bank_code" => $bankCode]);

            $accountInfo = $response->json();

            if ($accountInfo["status"] === true) {
                $bankInfo = $response->collect("data");
                if (isset($bankInfo["account_name"])) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }
        } catch (\Exception $e) {
            \Log::error($e);
            return false;
        }
    }

    /**
     * processSingleTransfer
     *
     * @param Request request
     *
     * @return void
     */
    public function processSingleTransfer(Request $request)
    {
        $validator = $this->validate($request, [
            'bank_code'      => 'required',
            'account_number' => 'required',
            'account_name'   => 'required',
            'amount'         => 'required',
            'narration'      => 'required',
        ]);

        $bank = Bank::where("bank_code", $request->bank_code)->first();
        if (! isset($bank)) {
            return ResponseHelper::error('Bank with provided bank code does not exist', 400);
        }

        $validated = $this->validateBankAccount($request->bank_code, $request->account_number);

        if ($validated !== true) {
            return ResponseHelper::error('Account details validation failed.', 400);
        }

        try {
            DB::beginTransaction();

            $response = Http::accept('application/json')->withHeaders([
                'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
            ])->post("https://api.paystack.co/transferrecipient", [
                "type"           => "nuban",
                "name"           => $request->account_name,
                "account_number" => $request->account_number,
                "bank_code"      => $request->bank_code,
                "currency"       => "NGN",
            ]);

            $result = $response->json();

            if ($result["status"] === true) {

                $data = $response->collect("data");

                $recipient = $data["recipient_code"];
                $reference = Uuid::uuid4();

                //Initiate the Actual Transfer

                $response = Http::accept('application/json')->withHeaders([
                    'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                ])->post("https://api.paystack.co/transfer", [
                    "source"    => "balance",
                    "reason"    => $request->narration,
                    "amount"    => (abs($request->amount) * 100),
                    "recipient" => $recipient,
                    "reference" => $reference,
                ]);

                $transferRes = $response->json();

                if ($transferRes["status"] === true) {
                    $transferData = $response->collect("data");

                    $trx                 = new PaymentHistory;
                    $trx->bank_name      = $bank->bank_name;
                    $trx->bank_code      = $bank->bank_code;
                    $trx->account_number = $request->account_number;
                    $trx->account_name   = $request->account_name;
                    $trx->amount         = $request->amount;
                    $trx->narration      = $request->narration;
                    $trx->remark         = "Funds Transferred to beneficiary";
                    $trx->trx_type       = "single";
                    $trx->status         = "payment successful";
                    $trx->user_id        = 1;
                    $trx->channel        = "api";
                    $trx->save();

                    DB::commit();

                    $data = [
                        "bank"          => $bank->bank_name,
                        "bankCode"      => $bank->bank_code,
                        "accountNumber" => $request->account_number,
                        "accountName"   => $request->account_name,
                        "amount"        => (double) $request->amount,
                        "narration"     => $request->narration,
                    ];

                    return ResponseHelper::trfSuccess($data);
                } else {
                    return ResponseHelper::error($transferRes["message"], 400);
                }
            } else {
                return ResponseHelper::error($result["message"], 400);
            }
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();
            return ResponseHelper::error($e->getMessage(), 400);
        }

    }
}
