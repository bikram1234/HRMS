<?php


namespace App\Http\Controllers\WorkStructure\basic_pay;

use App\Http\Controllers\Controller;


use App\Models\BasicPay;
use Illuminate\Http\Request;
use App\Models\grade;
class basic_payController extends Controller
{
    public function index()
    {
        $basicPays = BasicPay::with('grade')->get();
        return view('work_structure.basic_pay.index', compact('basicPays'));
    }

    
    public function create()
    {
        $grades = grade::all(); // Fetch all grades to populate a dropdown or select input in your form
        return view('work_structure.basic_pay.create', compact('grades'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'grade_id' => 'required|exists:grades,id', // Ensure that the selected grade exists
    //         'amount' => 'required|numeric', // Add any validation rules you need for the amount
    //     ]);

    //     BasicPay::create([
    //         'grade_id' => $request->input('grade_id'),
    //         'amount' => $request->input('amount'),
    //     ]);

    //     return redirect()->route('basic_pay.index')->with('success', 'Basic pay added successfully');
    // }
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'grade_id' => 'required|exists:grades,id', // Ensure that the selected grade exists
        'amount' => 'required|numeric', // Add any validation rules you need for the amount
    ]);

    // Check if a basic pay record with the same grade_id already exists
    $existingBasicPay = BasicPay::where('grade_id', $request->input('grade_id'))->first();

    if ($existingBasicPay) {
        // A basic pay record with the same grade_id already exists
        return redirect()->route('basic_pay.create')
            ->with('success', 'A basic pay record for this grade already exists.');
    }

    // If no existing record found, create a new basic pay record
    BasicPay::create([
        'grade_id' => $request->input('grade_id'),
        'amount' => $request->input('amount'),
    ]);

    return redirect()->route('basic_pay.index')->with('success', 'Basic pay added successfully');
}


    public function edit(BasicPay $basicPay)
    {
        $grades = Grade::all(); // Fetch all grades to populate a dropdown or select input in your form
        return view('work_structure.basic_pay.edit', compact('basicPay', 'grades'));
    }

    public function update(Request $request, BasicPay $basicPay)
    {
        $request->validate([
            //'grade_id' => 'required|exists:grades,id', // Ensure that the selected grade exists
            'amount' => 'required|numeric', // Add any validation rules you need for the amount
        ]);

        $basicPay->update([
           // 'grade_id' => $request->input('grade_id'),
            'amount' => $request->input('amount'),
        ]);

        return redirect()->route('basic_pay.index')->with('success', 'Basic pay updated successfully');
    }

    public function confirmDelete(BasicPay $basicPay)
    {
        return view('work_structure.basic_pay.confirm_delete', compact('basicPay'));
    }

    public function destroy(BasicPay $basicPay)
    {
        $basicPay->delete();
        return redirect()->route('basic_pay.index')->with('success', 'Basic pay deleted successfully');
    }

}