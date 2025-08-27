<?php
namespace App\Http\Controllers;

use App\Mail\BookingSuccessful as BookingSuccessful;
use App\Mail\TopupSuccessful as TopupSuccessful;
use App\Models\BankonePayments;
use App\Models\GuestAccounts;
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

            if ($data->trx_type == "credit" && $data->trx_status == "successful") {

                if ($data->classification == "inflow") {

                    $topupAmount = (double) ($data->amount / 100);

                    $user = User::find($data->business_id);

                    DB::beginTransaction();

                    $topup                 = new WalletTransactions;
                    $topup->user_id        = $user->id;
                    $topup->trx_type       = "credit";
                    $topup->reference      = $data->reference;
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
                        'message'    => "Transaction with Reference: { $data->reference} Successfully Processed.",
                    ]);

                }

                if ($data->classification == "booking") {

                    $trx = BankonePayments::where("account_number", $data->accountNumber)->where('handled', 0)->first();

                    if (isset($trx) && $trx != null) {
                        DB::beginTransaction();

                        $trx->handled = 1;
                        $trx->status  = "successful";
                        $trx->save();

                        $booking                  = TravelBooking::find($trx->transaction_id);
                        $booking->payment_status  = "paid";
                        $booking->payment_channel = "transfer";
                        $booking->booking_status  = "booked";
                        $booking->save();

                        $gA               = GuestAccounts::where('account_number', $trx->account_number)->first();
                        $gA->availability = 1;
                        $gA->save();

                        DB::commit();

                        Mail::to($booking)->send(new BookingSuccessful($booking));

                        return new JsonResponse([
                            'statusCode' => (int) 200,
                            'message'    => "Transaction with Reference: { $data->reference} Successfully Processed.",
                        ]);

                    }

                }

                if ($data->classification == "guest") {

                }

                return new JsonResponse([
                    'statusCode' => (int) 400,
                    'message'    => "Either Transaction is failed or transaction cannot be settled",
                ]);

            } else if ($data->trx_type == "debit" && $data->trx_status == "successful") {

                Log::channel('bankone')->info("");
                Log::channel('bankone')->info('Calling Bank One Debit Customer Function');
                // self::bankOneDebitCustomer();

            } else {

                Log::channel('bankone')->info("");
                Log::channel('bankone')->info('Either Transaction is failed or transaction type not credit or debit');

            }

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
