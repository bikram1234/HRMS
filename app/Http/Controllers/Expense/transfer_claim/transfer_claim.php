<?php
  
namespace App\Http\Controllers\Expense\transfer_claim;
use App\Http\Controllers\Controller; // Import the Controller class

  
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\BasicPay;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\ExpenseType;
use App\Mail\ExpenseApplicationMail;
use App\Models\ExpenseApprovalRule;
use App\Models\Expenseapproval_condition;
use App\Models\level;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
  
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
        'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file

    ], [
        'attachment.max' => 'The attachment file size must not exceed 2MB.',
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

    // Fetch the expense type id where the name is 'Expense Fuel'
    $expenseType = ExpenseType::where('name', 'Transfer Claim')->first();
    if (!$expenseType) {
        return redirect()->back()->with('success', 'Expense type not found.');
    }
    $expenseTypeId = $expenseType->id;
    $validated['expense_type_id'] = $expenseType->id;
     // Retrieve the associated policy for the selected expense type
     $policy = $expenseType->policies->first(); // Assuming you want the first associated policy
    
     if (!$policy) {
        return redirect()->back()             
        ->with('success', 'There is no policy defined for this Expense Type.');
     }
     // Find the rate definition associated with the policy_id
     $rateDefinition = $policy->rateLimits->first()->rateDefinition; // Assuming you want the first associated rate definition
    
     if (!$rateDefinition) {
        return redirect()->back()
                     ->with('success', 'This policy have not yet any Rate Definitions at all.');
     }
      // Check if attachment is required based on the rate definition
      if ($rateDefinition->attachment_required == 1) {
        // Attachment is required
        if (!$request->hasFile('attachment')) {
            return redirect()->back()
                            ->with('success', 'Attachment is required.');
        }

        $attachment = $request->file('attachment');
        if ($attachment->getSize() > 2048000) { // 2MB in bytes
            return redirect()->back()
                ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
                ->withInput();
        }

        $attachmentPath = $attachment->store('attachments', 'public');
        $validatedData['attachment'] = $attachmentPath;
    } else {
        // Attachment is not required
        $validatedData['attachment'] = null;
    }

    $validated['user_id'] = Auth::id(); // Assign the current user's ID

    $expense_id = $expenseTypeId;
    $sectionId = auth()->user()->section_id;
    $sectionHead = User::where('section_id', $sectionId)
    ->whereHas('designation', function($query) {
        $query->where('name', 'Section Head');
    })->first();

    $departmentId = auth()->user()->department_id;
    $departmentHead = User::where('department_id', $departmentId)
    ->whereHas('designation', function ($query) {
        $query->where('name', 'Department Head');
    })
    ->first();

    $approvalRuleId = ExpenseApprovalRule::where('type_id', $expense_id)->value('id');
    $approvalType = Expenseapproval_condition::where('approval_rule_id', $approvalRuleId)->first();
    $hierarchy_id = $approvalType->hierarchy_id;
    $currentUser = auth()->user();

    if ($approvalType->approval_type == "Hierarchy") {
        // Fetch the record from the levels table based on the $hierarchy_id
        $levelRecord = Level::where('hierarchy_id', $hierarchy_id)->first();

        if ($levelRecord) {
            // Access the 'value' field from the level record
            $levelValue = $levelRecord->value;

            // Determine the recipient based on the levelValue
            $recipient = '';

            // Check the levelValue and set the recipient accordingly
            if ($levelValue === "SH") {
                // Set the recipient to the section head's email address or user ID
                $recipient = $sectionHead->email; // Replace with the actual field name
            }
            $approval = $sectionHead;

            Mail::to($recipient)->send(new ExpenseApplicationMail($approval, $currentUser));
        }
    } 
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
