<?php

namespace App\Http\Controllers\Encashment\Apply;

use App\Http\Controllers\Controller;
use App\Models\appliedEncashment;
use App\Models\Encashment;
use App\Models\User;
use App\Models\leaveEncashmentApprovalRule;
use App\Models\leaveEncashmentApprovalCondition;
use App\Http\Requests\StoreappliedEncashmentRequest;
use App\Http\Requests\UpdateappliedEncashmentRequest;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;


class AppliedEncashmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreappliedEncashmentRequest $request)
    {
        $encashmentID = Encashment::value('id');
        $user = auth()->user()->name;
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
        

    
        $approvalRuleId = leaveEncashmentApprovalRule::where('type_id', $encashmentID)->value('id');
        $approvalType = leaveEncashmentApprovalCondition::where('leave_encashment_approval_rule_id', $approvalRuleId)->first();
        $hierarchy_id = $approvalType->hierarchy_id;

        if ($approvalType->approval_type == "Single User") {
            // Check the levelValue and set the recipient accordingly
            $recipient = User::where('id', $approvalType->employee_id)->value('email');

            $content = "Have applied for the leave encashment.";


            Mail::to($recipient)->send(new SendMail($user, $content));
        
            
        }
        // else if($approvalType->approval_type == "Single User"){
        //     dd($approvalType->employee_id)
        // }

        // Save the applied_leave record to the database
        appliedEncashment::create($request->validated());

        return redirect()->back()->with('success', 'Encashment Applied successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(appliedEncashment $appliedEncashment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(appliedEncashment $appliedEncashment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateappliedEncashmentRequest $request, appliedEncashment $appliedEncashment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(appliedEncashment $appliedEncashment)
    {
        //
    }
}
