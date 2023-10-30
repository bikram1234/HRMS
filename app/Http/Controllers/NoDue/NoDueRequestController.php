<?php

namespace App\Http\Controllers\NoDue;

use App\Http\Controllers\Controller;
use App\models\NoDueRequest;
use App\models\NoDueRequestApproval;
use App\models\User;

use Illuminate\Http\Request;

class NoDueRequestController extends Controller
{

    public function create(Request $request)
    {
        // Create a new No Due Request
        $request = new NoDueRequest([
            'user_id' => auth()->user()->id, // Assuming you're using authentication
            'reason' => $request->reason,
        ]);
        $request->save();

        // Send approval requests to section heads
        $sectionHeads = User::whereHas('designation', function ($query) {
            $query->where('name', 'Section Head');
        })->get();
        
        foreach ($sectionHeads as $sectionHead) {
            NoDueRequestApproval::create([
                'no_due_request_id' => $request->id,
                'user_id' => $sectionHead->id,
                'status' => 'pending',
            ]);
            
            // Send an email or notification to sectionHead with the request details
        }

        return redirect()->route('nodue.index'); // Redirect to the request list
    }

    public function index()
    {
        // List all No Due Requests
        $requests = NoDueRequest::all();
        return view('nodue.no_due_requests.index', compact('requests'));
    }

    public function show($id)
    {
        // Show details of a specific request
        $request = NoDueRequest::findOrFail($id);
        $approvals = NoDueRequestApproval::where('no_due_request_id', $request->id)->get();
        
        return view('no_due_requests.show', compact('request', 'approvals'));
    }
}


