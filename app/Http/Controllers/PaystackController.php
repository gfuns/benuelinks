<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\BookingSuccessful as BookingSuccessful;
use App\Mail\TopupSuccessful as TopupSuccessful;
use App\Models\GuestBooking;
use App\Models\PaystackTrx;
use App\Models\TravelBooking;
use App\Models\WalletTransactions;
use Auth;
use Coderatio\PaystackMirror\Actions\Transactions\VerifyTransaction;
use Coderatio\PaystackMirror\PaystackMirror;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;

class PaystackController extends Controller
{

    /**
     * initiateWalletTopup
     *
     * @return void
     */
    public function initiateWalletTopup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topup_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            alert()->error('', $errors);
            return back();
        }

        try {

            $topupAmount = abs(preg_replace("/,/", "", $request->topup_amount));

            $topup                 = new WalletTransactions;
            $topup->user_id        = Auth::user()->id;
            $topup->trx_type       = "credit";
            $topup->reference      = $this->genTrxId();
            $topup->amount         = $topupAmount;
            $topup->balance_before = Auth::user()->wallet_balance;
            $topup->balance_after  = ($topupAmount + Auth::user()->wallet_balance);
            $topup->description    = "Wallet Topup Transaction";

            if ($topup->save()) {
                $paystack                 = new PaystackTrx;
                $paystack->transaction_id = $topup->id;
                $paystack->reference      = "pm_rf" . Str::random(11);
                $paystack->amount         = $topup->amount;
                $paystack->trx_type       = "topup";
                if ($paystack->save()) {
                    $response = Http::accept('application/json')->withHeaders([
                        'authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                        'content_type'  => "Content-Type: application/json",
                    ])->post("https://api.paystack.co/transaction/initialize", [
                        "email"     => Auth::user()->email,
                        "amount"    => ($paystack->amount * 100),
                        "reference" => $paystack->reference,
                    ]);

                    $responseData = $response->collect("data");

                    if (isset($responseData['authorization_url'])) {
                        return redirect($responseData['authorization_url']);
                    }

                    alert()->error('', "Paystack gateway service took too long to respond");
                    return back();

                } else {
                    alert()->error('', "Failed to initialize wallet topup");
                    return back();
                }

            } else {
                alert()->error('', "Failed to initialize wallet topup");
                return back();
            }
        } catch (\Exception $e) {
            report($e);
            alert()->error('', "Failed to initialize wallet topup");
            return back();
        }
    }

    /**
     * payWithCard
     *
     * @param Request request
     *
     * @return void
     */
    public function payWithCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            alert()->error('', $errors);
            return back();
        }

        $booking = TravelBooking::find($request->booking_id);

        $paystack                 = new PaystackTrx;
        $paystack->transaction_id = $booking->id;
        $paystack->reference      = "pm_rf" . Str::random(11);
        $paystack->amount         = $booking->travel_fare;
        $paystack->trx_type       = "booking";
        if ($paystack->save()) {
            $response = Http::accept('application/json')->withHeaders([
                'authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                'content_type'  => "Content-Type: application/json",
            ])->post("https://api.paystack.co/transaction/initialize", [
                "email"     => Auth::user()->email,
                "amount"    => ($paystack->amount * 100),
                "reference" => $paystack->reference,
            ]);

            $responseData = $response->collect("data");

            if (isset($responseData['authorization_url'])) {
                return redirect($responseData['authorization_url']);
            }

            alert()->error('', "Paystack gateway service took too long to respond");
            return back();

        } else {
            alert()->error('', "Failed to initialize wallet topup");
            return back();
        }
    }

    /**
     * guestCardPayment
     *
     * @param Request request
     *
     * @return void
     */
    public function guestCardPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            alert()->error('', $errors);
            return back();
        }

        $booking = GuestBooking::find($request->booking_id);

        $paystack                 = new PaystackTrx;
        $paystack->transaction_id = $booking->id;
        $paystack->reference      = "pm_rf" . Str::random(11);
        $paystack->amount         = $booking->travel_fare;
        $paystack->trx_type       = "guest";
        if ($paystack->save()) {
            $response = Http::accept('application/json')->withHeaders([
                'authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                'content_type'  => "Content-Type: application/json",
            ])->post("https://api.paystack.co/transaction/initialize", [
                "email"     => $booking->email,
                "amount"    => ($paystack->amount * 100),
                "reference" => $paystack->reference,
            ]);

            $responseData = $response->collect("data");

            if (isset($responseData['authorization_url'])) {
                return redirect($responseData['authorization_url']);
            }

            alert()->error('', "Paystack gateway service took too long to respond");
            return back();

        } else {
            alert()->error('', "Failed to initialize wallet topup");
            return back();
        }
    }

    /**
     * handlePaystackCallback
     *
     * @param Request request
     *
     * @return void
     */
    public function handlePaystackCallback(Request $request)
    {
        $payment = PaystackMirror::run(env('PAYSTACK_SECRET_KEY'), new VerifyTransaction($request->reference))
            ->getResponse()->asObject();

        if (! isset($payment->data)) {
            alert()->error('', "Something Went Wrong!");
            if (Session::has('guestBookingID')) {
                return redirect()->route("guest.bookingPreview", [decrypt(Session::get('guestBookingID'))]);
            } else {
                return redirect()->route("passenger.dashboard");
            }
        }

        $paystack = PaystackTrx::where("reference", $payment->data->reference)->where('handled', 0)->first();
        if ($paystack != null) {
            $paystack->handled = 1;
            $paystack->status  = $payment->data->status == "success" ? "successful" : "failed";

            if ($paystack->save()) {

                if ($paystack->trx_type == "topup") {
                    return $this->updateTopupTransaction($paystack->transaction_id, $paystack->status);
                } elseif ($paystack->trx_type == "booking") {
                    return $this->updateBookingTransaction($paystack->transaction_id, $paystack->status);
                } else {
                    return $this->updateGuestTransaction($paystack->transaction_id, $paystack->status);
                }
            } else {
                alert()->error('', "Something Went Wrong!");

                if (Session::has('guestBookingID')) {
                    return redirect()->route("guest.bookingPreview", [decrypt(Session::get('guestBookingID'))]);
                } else {
                    return redirect()->route("passenger.dashboard");
                }
            }
        } else {
            alert()->error('', "This transaction has already been processed or does not exist on our records!");

            if (Session::has('guestBookingID')) {
                return redirect()->route("guest.bookingPreview", [decrypt(Session::get('guestBookingID'))]);
            } else {
                return redirect()->route("passenger.dashboard");
            }
        }
    }

    /**
     * updateTopupTransaction
     *
     * @param mixed trxId
     * @param mixed status
     *
     * @return void
     */
    public function updateTopupTransaction($trxId, $status)
    {
        try {

            if ($status == "successful") {
                $topup         = WalletTransactions::find($trxId);
                $topup->status = $status;
                $topup->save();

                $user                 = Auth::user();
                $user->wallet_balance = (double) ($user->wallet_balance + $topup->amount);

                if ($user->save()) {

                    try {

                        Mail::to($user)->send(new TopupSuccessful($user, $topup));

                    } catch (\Exception $e) {
                        \Log::error($e->getMessage());
                    } finally {
                        alert()->success('', "Wallet Topup Successful!");
                        return redirect()->route("passenger.wallet");
                    }

                }

                alert()->error('', "Something Went Wrong!");
                return redirect()->route("passenger.wallet");

            } else {
                $topup         = WalletTransactions::find($trxId);
                $topup->status = $status;
                $topup->save();

                alert()->error('', "Your card was declined. Please contact your card provider.");
                return redirect()->route("passenger.wallet");
            }
        } catch (\Exception $e) {
            report($e);

            alert()->error('', "Something Went Wrong!");
            return redirect()->route("passenger.wallet");
        }
    }

    /**
     * updateBookingTransaction
     *
     * @param mixed trxId
     * @param mixed status
     *
     * @return void
     */
    public function updateBookingTransaction($trxId, $status)
    {
        $booking = TravelBooking::find($trxId);
        if ($status == "successful") {
            $booking->payment_status  = "paid";
            $booking->payment_channel = "card payment";
            $booking->booking_status  = "booked";
            $booking->save();

            try {
                Mail::to($booking)->send(new BookingSuccessful($booking));
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            } finally {
                alert()->success('', 'Trip Booked Successfully!');
                return redirect()->route("passenger.bookingHistory");
            }

            alert()->success('', 'Trip Booked Successfully!');
            return redirect()->route("passenger.bookingHistory");
        } else {
            alert()->error('', 'Your card was declined. Please contact your card provider!');
            return redirect()->route("passenger.bookingPreview", [$trxId]);

        }
    }

    /**
     * updateGuestTransaction
     *
     * @param mixed trxId
     * @param mixed status
     *
     * @return void
     */
    public function updateGuestTransaction($trxId, $status)
    {
        try {
            $guest = GuestBooking::find($trxId);
            if ($status == "successful") {

                DB::beginTransaction();

                $guest->payment_status  = "paid";
                $guest->payment_channel = "card payment";
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
                $booking->booking_number  = $this->genBookingID();
                $booking->booking_method  = "online";
                $booking->booking_status  = $guest->booking_status;
                $booking->save();

                DB::commit();

                Session::forget('guestBookingID');

                try {
                    Mail::to($booking)->send(new BookingSuccessful($booking));
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                } finally {
                    alert()->success('', 'Trip Booked Successfully!');
                    return redirect()->route("guest.bookingReceipt", [$booking->id]);
                }

                alert()->success('', 'Trip Booked Successfully!');
                return redirect()->route("guest.bookingReceipt", [$booking->id]);
            } else {
                alert()->error('', 'Your card was declined. Please contact your card provider!');
                return redirect()->route("guest.bookingPreview", [$trxId]);

            }
        } catch (\Exception $e) {
            DB::rollback();
            report($e);
            alert()->error('', 'Something Went Wrong!');
            return redirect()->route("guest.bookingPreview", [$trxId]);
        }
    }

    /**
     * genBookingID
     *
     * @return void
     */
    public function genBookingID()
    {
        // Get the current timestamp
        $timestamp = (string) (strtotime('now') . microtime(true));

        // Remove any non-numeric characters (like dots)
        $cleanedTimestamp = preg_replace('/[^0-9]/', '', $timestamp);

        // Shuffle the digits
        $shuffled = str_shuffle($cleanedTimestamp);

        // Extract the first 12 characters
        $code = substr($shuffled, 0, 12);

        return "PMT-BK-" . $code;
    }

    /**
     * genTrxId
     *
     * @return void
     */
    public function genTrxId()
    {
        $pin  = range(0, 12);
        $set  = shuffle($pin);
        $code = "";
        for ($i = 0; $i < 12; $i++) {
            $code = $code . "" . $pin[$i];
        }

        return "PMT" . $code;
    }
}
