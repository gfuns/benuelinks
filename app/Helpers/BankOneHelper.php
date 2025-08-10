<?php
namespace App\Helpers;

use Auth;

class BankOneHelper
{
    public static function accountBalance()
    {
        $user = Auth::user();
        return 25000;
    }

    public static function debitAccount($amount)
    {
        $user = Auth::user();
        return false;
    }

}
