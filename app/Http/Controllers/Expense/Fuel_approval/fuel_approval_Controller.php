<?php

namespace App\Http\Controllers\Expense\Fuel_approval;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Fuel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class fuel_approval_Controller extends Controller
{
    public function fuel_approval(Request $request){
        $status = $request->input('status');

        $query = Fuel::query();

    if ($status) {
        $query->where('status', $status);
    } else {
        $query->whereIn('status', ['pending', 'approved']);
    }

    $fuel_approval = $query->get();

    return view('Expense.Fuel_approval.fuel_approval_show', compact('fuel_approval'));
    }
}