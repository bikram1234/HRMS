<?php

namespace App\Http\Controllers\Expense\expense_fuel;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Fuel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseType;
use App\Mail\ExpenseApplicationMail;
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Models\level;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Mail;






class fuel_claim extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $fuels = Fuel::latest()->paginate(5); // Change from 'Product' to 'Fuel'
        
        return view('Expense.Fuels.index', compact('fuels'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $vehicle = Vehicle::all();
        return view('Expense.Fuels.create', compact('vehicle'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'employee_name' => 'required',
        'location' => 'required',
        'date' => 'required',
        'vehicle_no' => 'required',
        'vehicle_type' => 'required',
        'initial_km' => 'required',
        'final_km' => 'required',
        'quantity' => 'required',
        'mileage' => 'required',
        'rate' => 'required',
        'amount' => 'required',
        'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file

    ], [
        'attachment.max' => 'The attachment file size must not exceed 2MB.',
    ]);

    $validated = $request->all();
    $validated['user_id'] = Auth::id();

    // Fetch the expense type id where the name is 'Expense Fuel'
    $expenseType = ExpenseType::where('name', 'Expense Fuel')->first();
    if (!$expenseType) {
        return redirect()->back()->with('error', 'Expense type not found.');
    }
    $expenseTypeId = $expenseType->id;
    $validated['expense_type_id'] = $expenseType->id;
     // Retrieve the associated policy for the selected expense type
     $policy = $expenseType->policies->first(); // Assuming you want the first associated policy
    
     if (!$policy) {
         return redirect()->route('fuels.create')
             ->with('success', 'There is no policy defined for this Expense Type.');
     }
     // Find the rate definition associated with the policy_id
     $rateDefinition = $policy->rateLimits->first()->rateDefinition; // Assuming you want the first associated rate definition
    
     if (!$rateDefinition) {
         return redirect()->route('fuels.create')
             ->with('success', 'This policy have not yet any Rate Definitions at all.');
     }
      // Check if attachment is required based on the rate definition
      if ($rateDefinition->attachment_required == 1) {
        // Attachment is required
        if (!$request->hasFile('attachment')) {
            return redirect()->route('fuels.create')
                ->with('success', 'Attachment is required.');
        }

        $attachment = $request->file('attachment');
        if ($attachment->getSize() > 2048000) { // 2MB in bytes
            return redirect()->route('fuels.create')
                ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
                ->withInput();
        }

    //  $attachmentPath = $attachment->storeAs('uploads', $attachment->getClientOriginalName(), 'local');
    // $validatedData['attachment'] = $attachmentPath;
     }
     if ($request->hasFile('attachment')) {
     $attachment = $request->file('attachment');
         $attachmentPath = $attachment->storeAs('uploads', $attachment->getClientOriginalName(), 'local');
         $validated['attachment'] = $attachmentPath;
        }else{
        
            $attachmentPath= null;
        }
    
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

                $approvalRuleId = approvalRule::where('type_id', $expense_id)->value('id');
                $approvalType = approval_condition::where('approval_rule_id', $approvalRuleId)->first();
                if(!$approvalType || !$approvalType->hierarchy_id){
                    return back()->withInput()
                        ->with('success', 'There is no approval for this Advance type');  
                }
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



    Fuel::create($validated);

    return redirect()->route('fuels.index')
        ->with('success', 'Fuel entry created successfully.');
}

  
    /**
     * Display the specified resource.
     */
    public function show(Fuel $fuel): View // Change the parameter name
    {
        return view('Expense.Fuels.show', compact('fuel')); // Change the view name
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fuel $fuel): View // Change the parameter name
    {
        return view('Expense.Fuels.edit', compact('fuel')); // Change the view name
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fuel $fuel): RedirectResponse // Change the parameter name
    {
        $request->validate([
            'employee_name' => 'required', 
            'date' => 'required',
            'vehicle_no' => 'required',
            'vehicle_type' => 'required',
            'initial_km' => 'required',
            'final_km' => 'required',
            'quantity' => 'required',
            'mileage' => 'required',
            'rate' => 'required',
            'amount' => 'required',
        ]);
        
        $fuel->update($request->all()); // Change from 'Product' to 'Fuel'
        
        return redirect()->route('fuels.index')
                        ->with('success', 'Fuel entry updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fuel $fuel): RedirectResponse // Change the parameter name
    {
        $fuel->delete(); // Change from 'Product' to 'Fuel'
         
        return redirect()->route('fuels.index')
                        ->with('success', 'Fuel entry deleted successfully');
    }
}
