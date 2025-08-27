<?php
namespace App\Http\Controllers;

use App\Mail\BookingSuccessful as BookingSuccessful;
use App\Mail\TopupSuccessful as TopupSuccessful;
use App\Models\BankonePayments;
use App\Models\GuestAccounts;
use App\Models\GuestBooking;
use App\Models\TravelBooking;
use App\Models\User;
use App\Models\WalletTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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

                    $trx = BankonePayments::where("account_number", $data->recipientAccountNumber)->where('handled', 0)->first();

                    Log::channel('bankone')->info($trx);

                    if (isset($trx) && $trx != null) {

                        if ($trx->trx_type == "booking") {

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

                        if ($trx->trx_type == "guest") {

                            $guest = GuestBooking::find($trx->transaction_id);

                            DB::beginTransaction();

                            $guest->payment_status  = "paid";
                            $guest->payment_channel = "transfer";
                            $guest->booking_status  = "booked";
                            $guest->save();

                            $booking                  = new TravelBooking;
                            $booking->schedule_id     = $guest->schedule_id;
                            $booking->departure       = $guest->departure;
                            $booking->destination     = $guest->destination;
                            $booking->vehicle         = $guest->vehicle;
                            $booking->vehicle_type    = $guest->vehicle_type;
                            $booking->travel_date     = $guest->travel_date;
                            $booking->departure_time  = $guest->departure_time;
                            $booking->full_name       = $guest->full_name;
                            $booking->phone_number    = $guest->phone_number;
                            $booking->nok             = $guest->nok;
                            $booking->nok_phone       = $guest->nok_phone;
                            $booking->email           = $guest->email;
                            $booking->gender          = $guest->gender;
                            $booking->seat            = $guest->seat;
                            $booking->payment_channel = $guest->payment_channel;
                            $booking->classification  = "booking";
                            $booking->payment_status  = $guest->payment_status;
                            $booking->travel_fare     = $guest->travel_fare;
                            $booking->booking_number  = $guest->booking_number;
                            $booking->booking_method  = "online";
                            $booking->booking_status  = $guest->booking_status;
                            $booking->save();

                            DB::commit();

                            Session::forget('guestBookingID');

                            Mail::to($booking)->send(new BookingSuccessful($booking));

                            return new JsonResponse([
                                'statusCode' => (int) 200,
                                'message'    => "Transaction with Reference: { $data->reference} Successfully Processed.",
                            ]);

                        }

                    }

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

            Log::channel('bankone')->error($e->getMessage());

            return new JsonResponse([
                'statusCode' => (int) 400,
                'message'    => $e->getMessage(),
            ]);
        }
    }

}
