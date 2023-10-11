<?php
  
namespace App\Http\Controllers\Expense\transfer_claim_approval;
use App\Http\Controllers\Controller; // Import the Controller class

  
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\BasicPay;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
  
class transfer_claim_approval_Controller extends Controller
{
    public function transfer_claim_approval_show(Request $request){
        $status = $request->input('status');

        $query = Product::query();

    if ($status) {
        $query->where('status', $status);
    } else {
        $query->whereIn('status', ['pending', 'approved']);
    }

    $transfer_approval = $query->get();

    return view('Expense.transfer_claim_approval.transfer_claim_approval_show', compact('transfer_approval'));
    }
    
}