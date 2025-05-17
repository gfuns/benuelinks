<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TopupSuccessful as TopupSuccessful;
use App\Models\PaystackTrx;
use App\Models\TravelBooking;
use App\Models\WalletTransactions;
use Auth;
use Coderatio\PaystackMirror\Actions\Transactions\VerifyTransaction;
use Coderatio\PaystackMirror\PaystackMirror;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            return redirect()->route("passenger.dashboard");
        }

        $paystack = PaystackTrx::where("reference", $payment->data->reference)->where('handled', 0)->first();
        if ($paystack != null) {
            $paystack->handled = 1;
            $paystack->status  = $payment->data->status == "success" ? "successful" : "failed";

            if ($paystack->save()) {

                if ($paystack->trx_type == "topup") {
                    return $this->updateTopupTransaction($paystack->transaction_id, $paystack->status);
                } else {
                    return $this->updateBookingTransaction($paystack->transaction_id, $paystack->status);
                }
            } else {
                alert()->error('', "Something Went Wrong!");
                return redirect()->route("passenger.dashboard");
            }
        } else {
            alert()->error('', "This transaction has already been processed or does not exist on our records!");
            return redirect()->route("passenger.dashboard");
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
            $booking->payment_channel = "wallet";
            $booking->booking_status  = "booked";
            $booking->save();

            alert()->success('', 'Trip Booked Successfully!');
            return redirect()->route("passenger.bookingHistory");
        } else {
            alert()->success('', 'Your card was declined. Please contact your card provider!');
            return redirect()->route("passenger.bookingPreview", [$trxId]);

        }
    }

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
