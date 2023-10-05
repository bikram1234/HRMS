<?php

namespace App\Http\Controllers\Leave\Policy;

use App\Http\Controllers\Controller;
use App\Models\leave_policy;
use App\Models\leavetype;
use App\Http\Requests\Storeleave_policyRequest;
use App\Http\Requests\Updateleave_policyRequest;

class LeavePolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leavetypes = leavetype::all();

        $leave_policies = leave_policy::all();
        return view('leave.policy.leavePolicy', compact('leave_policies', 'leavetypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leavetypes = leavetype::all();
        return view('leave.policy.leavePolicy', compact('leavetypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeleave_policyRequest $request)
    {
        $data = $request->validated();
    
        // Convert checkbox fields to boolean values
        $data['is_information_only'] = $request->has('is_information_only') ? 1 : 0;
    
        $leavePolicy = leave_policy::create($data);
        // Retrieve the leave_id from the created leave_policy
        $leave_id = $leavePolicy->leave_id;
    
        // Redirect to the leave-plan create page with the leave_id parameter
        //display the message 
        $notification = array(
            'message' => 'Leave Policy Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('leaveplan.create', ['leave_id' => $leave_id])->with($notification);
        
    }
    

    /**
     * Display the specified resource.
     */
    public function show(leave_policy $leave_policy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leave_policy $leave_policy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateleave_policyRequest $request, leave_policy $leave_policy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leave_policy $leave_policy)
    {
        //
    }
}
