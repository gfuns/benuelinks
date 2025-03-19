<?php
namespace App\Http\Controllers;

use App\Exports\BankCodeExport;
use App\Models\Bank;
use App\Models\PaymentFiles;
use App\Models\PaymentHistory;
use App\Models\TempPaymentBeneficiary;
use App\Models\TempPaymentFiles;
use App\Models\User;
use App\Models\UserPermission;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Ramsey\Uuid\Uuid;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view("dashboard");
    }

    /**
     * profile
     *
     * @return void
     */
    public function profile()
    {
        $permissions = UserPermission::where("role_id", Auth::user()->role->id)->get();
        return view("profile", compact("permissions"));
    }

    /**
     * changePassword
     *
     * @return void
     */
    public function changePassword()
    {
        return view("change_password");
    }

    /**
     * updatePassword
     *
     * @param Request request
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'      => 'required',
            'new_password'          => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            toast('Invalid current password provided.', 'error');
            return back();
        } else {
            if ($request->new_password != $request->password_confirmation) {
                toast('Your newly seleted passwords do not match.', 'error');
                return back();
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();
            }
        }

        if ($user->save()) {
            return back()->with(["success" => "Password Changed successfully."]);
        } else {
            return back()->with(["error" => "Something went wrong."]);
        }

    }

    /**
     * singleTransfer
     *
     * @return void
     */
    public function singleTransfer()
    {
        $banks = Bank::all();
        return view("single_transfer", compact("banks"));
    }

    /**
     * validateBankAccount
     *
     * @param Request request
     *
     * @return void
     */
    public function validateBankAccount(Request $request)
    {

        $response = Http::accept('application/json')->withHeaders([
            'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
        ])->get("https://api.paystack.co/bank/resolve", ["account_number" => $request->accountnumber, "bank_code" => $request->bank]);

        $accountInfo = $response->json();

        if ($accountInfo["status"] === true) {
            $bankInfo = $response->collect("data");
            if (isset($bankInfo["account_name"])) {
                return response()->json(['account_name' => $bankInfo["account_name"]], 200);
            } else {
                return response()->json(['message' => "AGUNTA Account Number Validation Failed"], 400);
            }

        } else {
            return response()->json(['message' => "Samuel Account Number Validation Failed"], 400);
        }
    }

    /**
     * processSingleTransfer
     *
     * @param Request request
     *
     * @return void
     */
    public function processSingleTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank'           => 'required',
            'account_number' => 'required',
            'account_name'   => 'required',
            'amount'         => 'required',
            'narration'      => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $bank = Bank::where("bank_code", $request->bank)->first();
        if (! isset($bank)) {
            return back()->with(["error" => "Something went wrong: Bank does not exist"]);
        }

        try {
            DB::beginTransaction();

            $response = Http::accept('application/json')->withHeaders([
                'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
            ])->post("https://api.paystack.co/transferrecipient", [
                "type"           => "nuban",
                "name"           => $request->account_name,
                "account_number" => $request->account_number,
                "bank_code"      => $request->bank,
                "currency"       => "NGN",
            ]);

            $result = $response->json();

            if ($result["status"] === true) {

                $data = $response->collect("data");

                $recipient = $data["recipient_code"];
                $reference = Uuid::uuid4();

                //Initiate the Actual Transfer

                $response = Http::accept('application/json')->withHeaders([
                    'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                ])->post("https://api.paystack.co/transfer", [
                    "source"    => "balance",
                    "reason"    => $request->narration,
                    "amount"    => (abs($request->amount) * 100),
                    "recipient" => $recipient,
                    "reference" => $reference,
                ]);

                $transferRes = $response->json();

                if ($transferRes["status"] === true) {
                    $transferData = $response->collect("data");

                    $trx                 = new PaymentHistory;
                    $trx->bank_name      = $bank->bank_name;
                    $trx->bank_code      = $bank->bank_code;
                    $trx->account_number = $request->account_number;
                    $trx->account_name   = $request->account_name;
                    $trx->amount         = $request->amount;
                    $trx->narration      = $request->narration;
                    $trx->remark         = "Funds Transferred to beneficiary";
                    $trx->trx_type       = "single";
                    $trx->status         = "successful";
                    $trx->user_id        = Auth::user()->id;
                    $trx->save();

                    DB::commit();

                    toast('Transfer Successful.', 'success');
                    return back();
                } else {
                    toast($transferRes["message"], 'error');
                    return redirect()->back();
                }
            } else {
                toast($result["message"], 'error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::info($e->getMessage());
            toast($e->getMessage(), 'error');
            return redirect()->back();
        }

    }

    /**
     * singleTransactionHistory
     *
     * @return void
     */
    public function singleTransactionHistory()
    {
        $transactions = PaymentHistory::orderBy("id", "desc")->where("trx_type", "single")->get();
        return view("transfer_history_single", compact("transactions"));
    }

    /**
     * bulkTransactionHistory
     *
     * @return void
     */
    public function bulkTransactionHistory()
    {
        $files = PaymentFiles::orderBy("id", "desc")->get();
        return view("transfer_history_bulk", compact("files"));
    }

    /**
     * bulkTransfer
     *
     * @return void
     */
    public function bulkTransfer()
    {
        $trackingcode = Str::random(6) . "-" . strtotime(now());
        return view("bulk_transfer", compact("trackingcode"));
    }

    /**
     * processBulkTransfer
     *
     * @param Request request
     *
     * @return void
     */
    public function processBulkTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name'     => 'required|unique:payment_files',
            'memo'          => 'required',
            'payment_file'  => 'required',
            'tracking_code' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {

            $trackingcode = $request->tracking_code;

            $tempFile                = new TempPaymentFiles;
            $tempFile->file_name     = $request->file_name;
            $tempFile->memo          = $request->memo;
            $tempFile->tracking_code = $trackingcode;
            $tempFile->save();

            // Get the file from the request
            $file = $request->file('payment_file');

            ini_set('max_execution_time', 600); // 10 minutes

            ini_set('memory_limit', '1G'); // 1 GB of memory

            // Load the Excel file

            $spreadsheet = IOFactory::load($file);

            // Get the first sheet
            $sheet = $spreadsheet->getSheet(0);

            // Convert the sheet to an array
            $rows = $sheet->toArray();

            $maxRecords = 150000; // Skip the header row (index 0)

            $data     = [];
            $imported = 0;
            $count    = 0;
            $comment  = null;
            // Define the chunk size (how many records to process at once)
            $chunkSize = 200;

            // Loop through each row of the spreadsheet, starting from row 2 (skip header)
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex === 1) {
                    continue; // Skip header row
                }

                // Stop processing after 15000 records
                if ($count >= $maxRecords) {
                    break;
                }

                // Get the cells of the current row
                $rowData      = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Iterate all cells, even empty ones

                // Populate the rowData array with the values from the cells
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Add the row data to the $data array
                // Example assuming the table has columns column1, column2, column3
                if (isset($rowData[1]) && isset($rowData[2]) && isset($rowData[3]) && isset($rowData[4])) {

                    $bank = Bank::where("bank_code", $rowData[3])->first();
                    if (! isset($bank)) {
                        $comment  = "Invalid Bank Information. Provided Bank Code does not exist on PayStack";
                        $imported = 0;
                    }

                    if (isset($bank)) {

                        $imported = 1;
                        $comment  = null;

                    }

                    $data[] = [

                        'file_id'        => $tempFile->id,
                        'account_name'   => $rowData[1],
                        'account_number' => $rowData[2],
                        'bank_code'      => isset($bank) ? $bank->bank_code : $rowData[3],
                        'bank_name'      => isset($bank) ? $bank->bank_name : null,
                        'amount'         => $rowData[4],
                        'tracking_code'  => $trackingcode,
                        'comment'        => $comment,
                        'imported'       => $imported,
                    ];

                    $count++;
                }

                // If the data array reaches the chunk size, insert it into the database
                if (count($data) >= $chunkSize) {
                    DB::table('temp_payment_beneficiaries')->insert($data); // Batch insert into DB
                    $data = [];
                }
            }

            // Insert any remaining rows that didn't reach the chunk size
            if (count($data) > 0) {
                DB::table('temp_payment_beneficiaries')->insert($data);
            }

            gc_collect_cycles();

            Session::put("bulkTransferSession", $trackingcode);
            return back();

        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    /**
     * exportBankCodes
     *
     * @return void
     */
    public function exportBankCodes()
    {
        $filename = "Bank_Codes_" . strtotime(now()) . ".xlsx";
        return Excel::download(new BankCodeExport(), $filename);
    }

    /**
     * bulkTransferUploadReport
     *
     * @param mixed trackingCode
     *
     * @return void
     */
    public function bulkTransferUploadReport($trackingCode)
    {
        Session::forget("bulkTransferSession");

        $banks        = Bank::all();
        $uploadReport = TempPaymentBeneficiary::orderBy("imported", "asc")->where("tracking_code", $trackingCode)->get();
        $uploadErrors = TempPaymentBeneficiary::where("tracking_code", $trackingCode)->where("imported", 0)->count();
        return view("bulkTransferUploadReport", compact("uploadReport", "trackingCode", "banks", "uploadErrors"));
    }

    /**
     * screenBulkTransferUpload
     *
     * @param mixed trackingCode
     *
     * @return void
     */
    public function screenBulkTransferUpload($trackingCode)
    {
        $beneficiaries = TempPaymentBeneficiary::where("tracking_code", $trackingCode)->where("imported", 0)->get();

        foreach ($beneficiaries as $ben) {
            $bank = Bank::where("bank_code", $ben->bank_code)->first();
            if (! isset($bank)) {
                $ben->comment = "Invalid Bank Information. Provided Bank Code does not exist on PayStack";
                $ben->save();
            }

            if (isset($bank)) {
                try {
                    $ben->bank_name = $bank->bank_name;
                    $ben->bank_code = $bank->bank_code;
                    $ben->imported  = 1;
                    $ben->comment   = null;
                    $ben->save();

                } catch (\Exception $e) {
                    report($e);
                }
            }

        }

        return redirect()->route("bulkTransferUploadReport", [$trackingCode]);
    }

    /**
     * resolveBulkTransferImportIssue
     *
     * @param Request request
     *
     * @return void
     */
    public function resolveBulkTransferImportIssue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload_id'      => 'required',
            'bank'           => 'required',
            'account_name'   => 'required',
            'account_number' => 'required',
            'amount'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $beneficiary = TempPaymentBeneficiary::find($request->upload_id);
        if (isset($beneficiary)) {
            $bank = Bank::where("bank_code", $request->bank)->first();
            if (! isset($bank)) {
                toast("Invalid Bank Information. Provided Bank Code does not exist on PayStack", 'error');
                return back();
            }

            $beneficiary->account_name   = $request->account_name;
            $beneficiary->account_number = $request->account_number;
            $beneficiary->bank_name      = $bank->bank_name;
            $beneficiary->bank_code      = $bank->bank_code;
            $beneficiary->amount         = $request->amount;
            $beneficiary->imported       = 1;
            $beneficiary->comment        = null;
            $beneficiary->save();

            toast("Changes Implemented Successfully.", 'success');
            return redirect()->route("bulkTransferUploadReport", [$beneficiary->tracking_code]);

        } else {
            toast("Something Went Wrong.", 'error');
            return back();
        }
    }

    /**
     * finalizeBulkTransferUpload
     *
     * @param mixed trackingCode
     *
     * @return void
     */
    public function finalizeBulkTransferUpload($trackingCode)
    {
        try {
            DB::beginTransaction();

            $tempFile = TempPaymentFiles::where("tracking_code", $trackingCode)->first();
            if (isset($tempFile)) {

                $paymentFile            = new PaymentFiles;
                $paymentFile->file_name = $tempFile->file_name;
                $paymentFile->memo      = $tempFile->memo;
                $paymentFile->user_id   = Auth::user()->id;
                $paymentFile->save();

                $beneficiaries = TempPaymentBeneficiary::where("tracking_code", $trackingCode)->get();

                foreach ($beneficiaries as $ben) {
                    $payment                 = new PaymentHistory;
                    $payment->file_id        = $paymentFile->id;
                    $payment->account_name   = $ben->account_name;
                    $payment->account_number = $ben->account_number;
                    $payment->bank_name      = $ben->bank_name;
                    $payment->bank_code      = $ben->bank_code;
                    $payment->amount         = $ben->amount;
                    $payment->status         = "validating account details";
                    $payment->narration      = $paymentFile->memo;
                    $payment->user_id        = Auth::user()->id;
                    $payment->trx_type       = "bulk";
                    $payment->save();

                    $ben->delete();
                }

                $tempFile->delete();

                DB::commit();

                return redirect()->route("bulkTransactionHistory")->with(["success" => "Bulk Transfer File Uploaded successfully."]);
            } else {
                toast("Something Went Wrong.", 'error');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    /**
     * bulkTransferBeneficiaries
     *
     * @param mixed id
     *
     * @return void
     */
    public function bulkTransferBeneficiaries($id)
    {
        $paymentFile = PaymentFiles::find($id);
        if (isset($paymentFile)) {
            $beneficiaries = PaymentHistory::where("file_id", $id)->get();
            return view("bulk_transfer_beneficiaries", compact("beneficiaries", "paymentFile"));
        } else {
            toast("Something Went Wrong.", 'error');
            return back();
        }
    }

}
