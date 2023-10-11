<?php

namespace App\Http\Controllers\Advance\advance_approval;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Advance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SalaryAdvance;
use App\Models\DsaAdvance;


class advance_approval_Controller extends Controller
{
    public function advance_approval_show(Request $request)
{
    $status = $request->input('status');

    $query = Advance::query();

    if ($status) {
        $query->where('status', $status);
    } else {
        $query->whereIn('status', ['pending', 'approved']);
    }

    // Fetch SalaryAdvance records matching the status filter
    $salaryAdvances = SalaryAdvance::with('advanceType')->where('status', $status)->get();

    // Fetch DsaAdvance records matching the status filter
    $dsaAdvances = DsaAdvance::with('advanceType')->where('status', $status)->get();

    // Combine SalaryAdvance and DsaAdvance records into a single collection
    $advances = $salaryAdvances->concat($dsaAdvances);

    return view('Advance.advance_approval.advance_approval_show', compact('advances'));
}

}