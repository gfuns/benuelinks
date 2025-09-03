<?php
namespace App\Helpers;

use Auth;
use Illuminate\Support\Facades\Http;

class BankOneHelper
{
    public static function accountBalance()
    {
        $user = Auth::user();

        try {

            $baseURL   = env("BANK_ONE_BASE_URL");
            $authToken = env("MY_BANK_ONE_AUTH_TOKEN");
            $url       = $baseURL . '/BankOneWebAPI/api/Account/GetAccountByAccountNumber/2?authToken=' . $authToken . '&accountNumber=' . $user->account_number;

            $response = Http::Get($url);

            if ($response->failed()) {
                dd("Na here e dey fail");
                return 0;
            } else {
                // dd("It didn't fail");
                $data = json_decode($response, true);
                // \Log::info($data["AvailableBalance"]);
                if (isset($data["AvailableBalance"])) {
                    // dd("Preparing To Render");
                    $balance = preg_replace("/,/", "", $data["AvailableBalance"]);
                    // $balance = $data["WithdrawableBalance"];

                    $user                 = Auth::user();
                    $user->wallet_balance = $balance;
                    $user->save();

                    dd($balance);
                    return $balance;

                }
                dd("Rendering Zero");
                return 0;

            }
            dd("Rendering Zero value");
            return 0;

        } catch (\Exception $e) {

            report($e);
            dd($e->getMessage());

            return 0;
        }
    }

    public static function debitAccount($amount, $bookingNo)
    {
        $user = Auth::user();

        try {

            $baseURL   = env("BANK_ONE_BASE_URL");
            $authToken = env("MY_BANK_ONE_AUTH_TOKEN");
            $authToken = env("MY_BANK_ONE_AUTH_TOKEN");
            $glCode    = env("BANK_ONE_DEBIT_GL");
            $url       = $baseURL . '/thirdpartyapiservice/apiservice/CoreTransactions/Debit';
            $reference = self::genMiddlewareRef($user->id);

            // dd($url);

            $postData = [
                'RetrievalReference' => $reference,
                'AccountNumber'      => $user->account_number,
                'NibssCode'          => $user->bankOneBankId,
                'Amount'             => ($amount * 100),
                'Fee'                => 0,
                'Narration'          => "Payment for Trip with Booking No: {$bookingNo}",
                'Token'              => $authToken,
                'GLCode'             => $glCode,
            ];

            // dd($postData);

            $response = Http::post($url, $postData);
            // \Log::info($response);
            // dd($response);

            if ($response->failed()) {
                return [
                    "status"  => false,
                    "message" => "Request Failed",
                ];

            } else {

                $data = json_decode($response, true);
                // \Log::info($data);
                // dd($data);
                if ($data["IsSuccessful"] === false) {
                    toast($data["ResponseMessage"], 'error');
                    return [
                        "status"  => false,
                        "message" => $data["ResponseMessage"],
                    ];
                }

                if ($data["ResponseMessage"] != "Insufficient Funds") {
                    return [
                        "status"  => true,
                        "message" => $reference,
                    ];
                }

                return [
                    "status"  => false,
                    "message" => $data["ResponseMessage"],
                ];

            }
        } catch (\Exception $e) {
            report($e);
            return [
                "status"  => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public static function genMiddlewareRef($businessId)
    {
        $data = [
            "business_id" => $businessId,
        ];

        $url      = "https://peacemasstransit.ng/api/v1/generateReference";
        $response = Http::timeout(600)->accept('application/json')->withHeaders([
            'x-api-key' => env("MIDDLEWARE_KEY"),
        ])->post($url, $data);

        $data = json_decode($response, true);

        $reference = $data['response']['data'];

        return $reference;
    }

}
