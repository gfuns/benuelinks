<?php
namespace App\Http\Controllers;

use App\Mail\TopupSuccessful as TopupSuccessful;
use App\Models\User;
use App\Models\WalletTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;

class BankOneController extends Controller
{
    /**
     * handlePaystackCallback
     *
     * @param Request request
     *
     * @return void
     */
    public function webhookNotification(Request $request)
    {
        try {
            $data = (object) $request->all();

            Log::channel('bankone')->info("");
            Log::channel('bankone')->info('Incoming Data', (array) $data);

            $reference   = $data->reference;
            $topupAmount = $data->amount;
            $businessId  = $data->business_id;

            $user = User::find($businessId);

            DB::beginTransaction();

            $topup                 = new WalletTransactions;
            $topup->user_id        = $user->id;
            $topup->trx_type       = "credit";
            $topup->reference      = $reference;
            $topup->amount         = $topupAmount;
            $topup->balance_before = $user->wallet_balance;
            $topup->balance_after  = ($topupAmount + $user->wallet_balance);
            $topup->description    = "Wallet Topup Transaction";
            $topup->status         = "successful";
            $topup->save();

            $user->wallet_balance = (double) ($user->wallet_balance + $topup->amount);
            $user->save();

            DB::commit();

            Mail::to($user)->send(new TopupSuccessful($user, $topup));

            return new JsonResponse([
                'statusCode' => (int) 200,
                'message'    => "Data Received and Processed Successfully",
            ]);
        } catch (\Throwable $e) {
            DB::rollback();

            report($e);

            return new JsonResponse([
                'statusCode' => (int) 400,
                'message'    => $e->getMessage(),
            ]);
        }
    }
}
