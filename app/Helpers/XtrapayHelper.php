<?php
namespace App\Helpers;

use Auth;

class XtrapayHelper
{

    public static function debitAccount($amount, $bookingNo)
    {
        $user = Auth::user();

        try {

        } catch (\Exception $e) {
            report($e);
            return [
                "status"  => false,
                "message" => $e->getMessage(),
            ];
        }
    }

}
