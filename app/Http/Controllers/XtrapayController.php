<?php
namespace App\Http\Controllers;

use App\Mail\BookingSuccessful as BookingSuccessful;
use App\Mail\TopupSuccessful as TopupSuccessful;
use App\Models\GuestBooking;
use App\Models\TravelBooking;
use App\Models\User;
use App\Models\WalletTransactions;
use App\Models\XtrapayPayments;
use App\Models\XtrapayWebhooks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mail;

class XtrapayController extends Controller
{

    /**
     * webhookNotification
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

            $webhook                        = new XtrapayWebhooks;
            $webhook->event                 = $data->event;
            $webhook->reference             = $data->reference ?? null;
            $webhook->amount                = $data->amount;
            $webhook->account_number        = $data->accountNumber;
            $webhook->account_name          = $data->accountName;
            $webhook->status                = $data->status;
            $webhook->source_account_number = $data->sourceAccountNumber ?? null;
            $webhook->source_account_name   = $data->sourceAccountName ?? null;
            $webhook->source_bank           = $data->bank ?? null;
            $webhook->narration             = $data->narration ?? null;
            $webhook->session_id            = $data->sessionId ?? null;
            $webhook->settlement_id         = $data->settlementId ?? null;
            $webhook->payload               = json_encode($request->all());
            if ($webhook->save()) {

                $xtraPayment = XtrapayPayments::where("reference", $data->reference)->where('handled', 0)->first();

                if (isset($xtraPayment)) {

                    if ($xtraPayment->trx_type == "topup") {

                        try {
                            $user = User::where("account_number", $webhook->account_number)->first();

                            DB::beginTransaction();

                            $topup                 = new WalletTransactions;
                            $topup->user_id        = $user->id;
                            $topup->trx_type       = "credit";
                            $topup->reference      = $data->reference;
                            $topup->amount         = $webhook->amount;
                            $topup->balance_before = $user->wallet_balance;
                            $topup->balance_after  = ($webhook->amount + $user->wallet_balance);
                            $topup->description    = "Wallet Topup Transaction";
                            $topup->status         = "successful";
                            $topup->save();

                            $user->wallet_balance = (double) ($user->wallet_balance + $webhook->amount);
                            $user->save();

                            DB::commit();

                            Mail::to($user)->send(new TopupSuccessful($user, $topup));

                            return new JsonResponse([
                                'received' => true,
                            ]);

                        } catch (\Throwable $e) {
                            DB::rollback();
                            Log::channel('bankone')->error($e->getMessage());
                        }

                    }

                    if ($xtraPayment->trx_type == "booking") {

                        try {
                            DB::beginTransaction();

                            if ($xtraPayment->status == "success") {
                                $xtraPayment->handled = 1;
                                $xtraPayment->status  = "successful";
                                $xtraPayment->save();

                                $booking                  = TravelBooking::find($xtraPayment->transaction_id);
                                $booking->payment_status  = "paid";
                                $booking->payment_channel = "transfer";
                                $booking->booking_status  = "booked";
                                $booking->save();
                            } else {
                                $xtraPayment->handled = 1;
                                $xtraPayment->status  = "failed";
                                $xtraPayment->save();

                                $booking                 = TravelBooking::find($xtraPayment->transaction_id);
                                $booking->payment_status = "failed";
                                $booking->save();
                            }

                            DB::commit();

                            if ($xtraPayment->status == "success") {
                                Mail::to($booking)->send(new BookingSuccessful($booking));
                            }

                            return new JsonResponse([
                                'received' => true,
                            ]);
                        } catch (\Throwable $e) {
                            DB::rollback();
                            Log::channel('bankone')->error($e->getMessage());
                        }

                    }

                    if ($xtraPayment->trx_type == "guest") {
                        try {
                            DB::beginTransaction();

                            if ($xtraPayment->status == "success") {

                                $xtraPayment->handled = 1;
                                $xtraPayment->status  = "successful";
                                $xtraPayment->save();

                                $guest                  = GuestBooking::find($xtraPayment->transaction_id);
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
                            } else {
                                $xtraPayment->handled = 1;
                                $xtraPayment->status  = "failed";
                                $xtraPayment->save();

                                $guest                 = GuestBooking::find($xtraPayment->transaction_id);
                                $guest->payment_status = "failed";
                                $guest->save();
                            }

                            DB::commit();

                            if ($xtraPayment->status == "success") {
                                Session::forget('guestBookingID');
                                Mail::to($booking)->send(new BookingSuccessful($booking));
                            }

                            return new JsonResponse([
                                'received' => true,
                            ]);

                        } catch (\Throwable $e) {
                            DB::rollback();
                            Log::channel('bankone')->error($e->getMessage());
                        }

                    }
                }
            }

        } catch (\Throwable $e) {
            Log::channel('bankone')->error($e->getMessage());
        }
    }
}
