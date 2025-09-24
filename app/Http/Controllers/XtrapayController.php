<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
