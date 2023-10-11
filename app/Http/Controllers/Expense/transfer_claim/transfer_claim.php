<?php
  
namespace App\Http\Controllers\Expense\transfer_claim;
use App\Http\Controllers\Controller; // Import the Controller class

  
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\BasicPay;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
  
class transfer_claim extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(5);
        
        return view('Expense.transfer_claim.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Expense.transfer_claim.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'employee_id' => 'required',
    //         'designation' => 'required',
    //         'department' => 'required',
    //         'basic_pay' => 'required',
    //         'transfer_claim_type' => 'required',
    //         'claim_amount' => 'required',
    //         'current_location' => 'required',
    //         'new_location' => 'required',
    //         'distance_km' => 'nullable', //just change the value from required to nullable
    //     ]);
        
    //     Product::create($request->all());
         
    //     return redirect()->route('products.index')
    //         ->with('success', 'Product created successfully.');
    // }
    

public function store(Request $request): RedirectResponse
{
    $request->validate([
        'employee_id' => 'required',
        'designation' => 'required',
        'department' => 'required',
        'transfer_claim_type' => 'required',
        'claim_amount' => 'required',
        'current_location' => 'required',
        'new_location' => 'required',
        'distance_km' => 'nullable',
    ]);

    // Fetch the current user's grade_id from the users table
    $currentUser = Auth::user();
    $currentGradeId = $currentUser->grade_id;

    // Fetch the basic pay amount based on the current user's grade_id
    $basicPayAmount = BasicPay::where('grade_id', $currentGradeId)->value('amount');

    if (!$basicPayAmount) {
        // Handle the case where the basic pay amount is not found
        return redirect()->back()->withErrors(['designation' => 'Basic pay amount not found for the current user\'s grade.']);
    }

    // Set the 'basic_pay' field with the fetched basic pay amount
    $request->merge(['basic_pay' => $basicPayAmount]);

    $validated['user_id'] = Auth::id(); // Assign the current user's ID


    // Create the product record with the updated request data
    Product::create($request->all());

    return redirect()->route('products.index')
        ->with('success', 'Product created successfully.');
}

  
    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('Expense.transfer_claim.show', compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('Expense.transfer_claim.edit', compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'employee_id' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'basic_pay' => 'required',
            'transfer_claim_type' => 'required',
            'claim_amount' => 'required',
            'current_location' => 'required',
            'new_location' => 'required',
            'distance_km' => 'nullable',
        ]);
        
        $product->update($request->all());
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
         
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
