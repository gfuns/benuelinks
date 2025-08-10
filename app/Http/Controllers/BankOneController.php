<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $data = $request->all();

        \Log::info($data);

        // $reference   = $data->reference;
        // $topupAmount = $data->amount;
        // $businessId  = $data->businessId;

        // try {
        //     $user = User::find($businessId);

        //     $topup                 = new WalletTransactions;
        //     $topup->user_id        = $user->id;
        //     $topup->trx_type       = "credit";
        //     $topup->reference      = $reference;
        //     $topup->amount         = $topupAmount;
        //     $topup->balance_before = $user->wallet_balance;
        //     $topup->balance_after  = ($topupAmount + $user->wallet_balance);
        //     $topup->description    = "Wallet Topup Transaction";
        //     $topup->status         = "successful";
        //     if ($topup->save()) {

        //         Mail::to($user)->send(new TopupSuccessful($user, $topup));

        //     }
        // } catch (\Exception $e) {
        //     \Log::error($e->getMessage());
        // }
    }
}
