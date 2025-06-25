<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class EmiDetailsController extends Controller
{
    public function index()
    {
        $columns = [];
        $data = [];
        if (DB::select("SHOW TABLES LIKE 'emi_details'")) {
            $columns = array_map(function ($col) {
                return $col->Field;
            }, DB::select('SHOW COLUMNS FROM emi_details'));
            $data = DB::table('emi_details')->paginate(10);
        }
        return view('emi_details.index', compact('columns', 'data'));
    }

    public function process(Request $request)
    {
        try {
            // Drop table if exists
            DB::statement('DROP TABLE IF EXISTS emi_details');

            // Get min and max dates
            $minDate = DB::table('loan_details')->min('first_payment_date');
            $maxDate = DB::table('loan_details')->max('last_payment_date');
            if (!$minDate || !$maxDate) {
                return redirect()->route('emi_details.index')->with('error', 'No loan details found.');
            }
            $start = Carbon::parse($minDate)->startOfMonth();
            $end = Carbon::parse($maxDate)->startOfMonth();
            $months = [];
            $period = $start->copy();
            while ($period <= $end) {
                $months[] = $period->format('Y_M');
                $period->addMonth();
            }
            // Create table
            $cols = "id INT AUTO_INCREMENT PRIMARY KEY, clientid INT";
            foreach ($months as $m) {
                $cols .= ", `$m` DECIMAL(15,2) DEFAULT 0";
            }
            DB::statement("CREATE TABLE emi_details ($cols)");

            // Process each loan
            $loans = DB::table('loan_details')->get();
            foreach ($loans as $loan) {
                $emi = round($loan->loan_amount / $loan->num_of_payment, 2);
                $emiMonths = [];
                $first = Carbon::parse($loan->first_payment_date)->startOfMonth();
                $last = Carbon::parse($loan->last_payment_date)->startOfMonth();
                $clientMonths = [];
                $period = $first->copy();
                while ($period <= $last) {
                    $clientMonths[] = $period->format('Y_M');
                    $period->addMonth();
                }
                $emiValues = array_fill(0, count($clientMonths), $emi);
                // Adjust last EMI to match total
                $total = round($emi * count($clientMonths), 2);
                $diff = round($loan->loan_amount - $total, 2);
                if ($diff != 0 && count($emiValues) > 0) {
                    $emiValues[count($emiValues) - 1] += $diff;
                }
                $row = ['clientid' => $loan->clientid];
                foreach ($months as $m) {
                    $row[$m] = 0.00;
                }
                foreach ($clientMonths as $i => $m) {
                    $row[$m] = $emiValues[$i];
                }
                DB::table('emi_details')->insert($row);
            }
            return redirect()->route('emi_details.index')->with('success', 'EMI Details processed successfully.');
        } catch (Exception $e) {
            return redirect()->route('emi_details.index')->with('error', 'An error occurred while processing EMI Details: ' . $e->getMessage());
        }
    }
}
