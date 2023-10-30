<?php

namespace App\Http\Controllers\NoDue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\NoDueRequestApproval;
use App\models\NoDueRequest;
use App\models\User;
use App\models\Department;

class NoDueRequestApprovalController extends Controller
{

    public function index() 
    {
        $userID = auth()->user()->id;
        $requests = NoDueRequestApproval::where('user_id', $userID)->get();
        return view('nodue.no_due_requests.approval', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        // Approve a request
    
        $currentUser = auth()->user();
        $designation = $currentUser->designation->name;
        if( $designation== 'Section Head'){
            $approval = NoDueRequestApproval::findOrFail($id);
            $approval->status = 'approved';
            $approval->save();
            $departmentID = $currentUser->department_id;

            // Get the department's sections
            $sections = Department::find($departmentID)->sections;
            // Check if all section heads within a department have approved
            if ($this->checkSectionApproval($approval->noDueRequest, $sections)) {
                $departmentID = auth()->user()->department_id;

                $departmentHead = User::where('department_id', $departmentID)
                    ->whereHas('designation', function ($query) {
                        $query->where('name', 'Department Head');
                    })
                    ->first();

                    NoDueRequestApproval::create([
                        'no_due_request_id' => $approval->noDueRequest->id,
                        'user_id' => $departmentHead->id,
                        'status' => 'pending',
                    ]);

            }
        }else if($designation == 'Department Head'){
            $approval = NoDueRequestApproval::findOrFail($id);
            $approval->status = 'approved';
            $approval->save();
            if ($this->checkDepartmentApproval($approval->noDueRequest)) {
             
                $approval->noDueRequest->status = 'approved';
                $approval->noDueRequest->save();
            }
        }
        
        

        return redirect()->route('nodueapproval.index', $approval->no_due_request_id);
    }

    public function decline(Request $request, $id)
    {
        // Decline a request
        $approval = NoDueRequestApproval::findOrFail($id);
        $approval->status = 'declined';
        $approval->save();

        // Update the status of the request
        $approval->noDueRequest->status = 'declined';
        $approval->noDueRequest->save();

        return redirect()->route('nodueapproval.index', $approval->no_due_request_id);
    }

    private function checkSectionApproval(NoDueRequest $request, $sections)
{
    foreach ($sections as $section) {
        $sectionHeads = $section->users()
            ->whereHas('designation', function ($query) {
                $query->where('name', 'Section Head');
            })->get();

        foreach ($sectionHeads as $sectionHead) {
            $approval = NoDueRequestApproval::where('no_due_request_id', $request->id)
                ->where('user_id', $sectionHead->id)
                ->first();

            if (!$approval || $approval->status !== 'approved') {
                return false; // Not all section heads in the department have approved
            }
        }
    }

    return true; // All section heads in the department have approved
}

 

    private function checkDepartmentApproval(NoDueRequest $request)
    {
        // Fetch all departments
        $departments = Department::all();

        foreach ($departments as $department) {
            $departmentHead = $department->users()
                ->whereHas('designation', function ($query) {
                    $query->where('name', 'Department Head');
                })->first();

            if (!$departmentHead) {
                // If a department has no department head, continue to the next department
                continue;
            }

            $approval = NoDueRequestApproval::where('no_due_request_id', $request->id)
                ->where('user_id', $departmentHead->id)
                ->first();

            if (!$approval || $approval->status === 'pending') {
                return false; // If any department head's status is pending, return false
            }
        }

        return true; // All department heads' statuses are not pending
    }


}