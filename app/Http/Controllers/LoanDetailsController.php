<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanDetails;

class LoanDetailsController extends Controller
{
    public function index()
    {
        $loans = LoanDetails::paginate(10);
        return view('loan_details.index', compact('loans'));
    }
}
