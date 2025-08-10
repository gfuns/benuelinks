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
                return 0;
            } else {
                $data = json_decode($response, true);
                \Log::info($data);
                if ($data["IsSuccessful"] === false) {
                    return 0;
                }

                $balance = 0;

                $user                 = Auth::user();
                $user->wallet_balance = $balance;
                $user->save();
            }
            return 0;

        } catch (\Exception $e) {

            report($e);

            return 0;
        }
    }

    public static function debitAccount($amount)
    {
        $user = Auth::user();
        return false;
    }

}
