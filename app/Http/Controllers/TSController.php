<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TSController extends Controller
{
    //

    public function tsAcctBal(Request $request)
    {
        try {

            $baseURL   = env("BANK_ONE_BASE_URL");
            $authToken = env("MY_BANK_ONE_AUTH_TOKEN");
            $url       = $baseURL . '/BankOneWebAPI/api/Account/GetAccountByAccountNumber/2?authToken=' . $authToken . '&accountNumber=' . $request->account_number;

            $response = Http::Get($url);

            if ($response->failed()) {
                return 0;
            } else {
                $data = json_decode($response, true);
                return $data;

                // \Log::info($data["AvailableBalance"]);
                if (isset($data["AvailableBalance"])) {
                    $balance = $data["AvailableBalance"];
                    // $balance = $data["WithdrawableBalance"];

                    return $balance;

                }
                return 0;

            }
            return 0;

        } catch (\Throwable $e) {

            report($e);

            return $e->getMessage();
        }
    }
}
