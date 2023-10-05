<?php

namespace App\Http\Controllers\Leave\YearEnd;

use App\Http\Controllers\Controller;
use App\Models\leave_yearend_processing;
use App\Models\leave_policy;
use App\Models\leave_plan;
use App\Models\leave_rule;
use Illuminate\Http\Request;
use App\Http\Requests\Storeleave_yearend_processingRequest;
use App\Http\Requests\Updateleave_yearend_processingRequest;
use Illuminate\Support\Facades\DB;


class LeaveYearendProcessingController extends Controller
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
    public function create($leave_id)
    {
        return view('leave.yearend.yearEndProcessingAdd', compact('leave_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeleave_yearend_processingRequest $request)
    {
        $data = leave_yearend_processing::create($request->validated());
        $leave_id = $data['leave_id'];
        //display the message 
        $notification = array(
            'message' => 'Leave Plan Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('showSummary.show', ['leave_id' => $leave_id])->with($notification);
    }

    public function showSummary($leave_id) {
        // Retrieve the leave policy, leave plan, leave rule, and yearendprocessing data for the given leave_id
        $leavePolicy = Leave_Policy::where('leave_id', $leave_id)->first();
        $leavePlan = Leave_Plan::where('leave_id', $leave_id)->first();
        $leaveRules = Leave_Rule::where('leave_id', $leave_id)->get();
        $yearEndProcessing = leave_yearend_processing::where('leave_id', $leave_id)->first();
    
        // Pass the data to the view
        return view('leave.summary.summaryShow', compact('leavePolicy', 'leavePlan', 'leaveRules', 'yearEndProcessing'));
    }

    public function leavePolicyView($leave_id) {
        // Retrieve the leave policy, leave plan, leave rule, and yearendprocessing data for the given leave_id
        $leavePolicy = Leave_Policy::where('leave_id', $leave_id)->first();
        $leavePlan = Leave_Plan::where('leave_id', $leave_id)->first();
        $leaveRules = Leave_Rule::where('leave_id', $leave_id)->get();
        $yearEndProcessing = leave_yearend_processing::where('leave_id', $leave_id)->first();
    
        // Pass the data to the view
        return view('leave.summary.leavePolicyView', compact('leavePolicy', 'leavePlan', 'leaveRules', 'yearEndProcessing'));
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(leave_yearend_processing $leave_yearend_processing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leave_yearend_processing $leave_yearend_processing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateleave_yearend_processingRequest $request, leave_yearend_processing $leave_yearend_processing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leave_yearend_processing $leave_yearend_processing)
    {
        //
    }

    public function deleteLeaveData($leave_id)
    {
        try {
            // Use a transaction to ensure data consistency
            DB::transaction(function () use ($leave_id) {
                // Delete data from the associated tables
                leave_plan::where('leave_id', $leave_id)->delete();
                leave_rule::where('leave_id', $leave_id)->delete();
                leave_policy::where('leave_id', $leave_id)->delete();
                leave_yearend_processing::where('leave_id', $leave_id)->delete();
            });

            // Redirect back with a success message
            return redirect()->route('leavepolicy.index')->with('success', 'Leave policy addition cancelled!!');
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur
            return redirect()->back()->with('error', 'Failed to delete leave data and associated records.');
        }
    }

    public function saveNow($leave_id) {
        return redirect()->route('leavepolicy.index')->with('success', 'Leave policy added successfully!!');
    }

}
