<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

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
    public function validateBankAccount(Request $request)
    {

        $response = Http::accept('application/json')->withHeaders([
            'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
        ])->get("https://api.paystack.co/bank/resolve", ["account_number" => $request->accountnumber, "bank_code" => $request->bank]);

        $accountInfo = $response->json();

        if ($accountInfo["status"] === true) {
            $bankInfo = $response->collect("data");
            if (isset($bankInfo["account_name"])) {
                return response()->json(['account_name' => $bankInfo["account_name"]], 200);
            } else {
                return response()->json(['message' => "AGUNTA Account Number Validation Failed"], 400);
            }

        } else {
            return response()->json(['message' => "Samuel Account Number Validation Failed"], 400);
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
        $validator = Validator::make($request->all(), [
            'bank_code'      => 'required',
            'account_number' => 'required',
            'account_name'   => 'required',
            'amount'         => 'required',
            'narration'      => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $bank = Bank::where("bank_code", $request->bank_code)->first();
        if (! isset($bank)) {
            return back()->with(["error" => "Something went wrong: Bank does not exist"]);
        }

        try {
            DB::beginTransaction();

            $response = Http::accept('application/json')->withHeaders([
                'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
            ])->post("https://api.paystack.co/transferrecipient", [
                "type"           => "nuban",
                "name"           => $request->account_name,
                "account_number" => $request->account_number,
                "bank_code"      => $request->bank,
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
                    $trx->status         = "successful";
                    $trx->user_id        = Auth::user()->id;
                    $trx->save();

                    DB::commit();

                    toast('Transfer Successful.', 'success');
                    return back();
                } else {
                    toast($transferRes["message"], 'error');
                    return redirect()->back();
                }
            } else {
                toast($result["message"], 'error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::info($e->getMessage());
            toast($e->getMessage(), 'error');
            return redirect()->back();
        }

    }
}
