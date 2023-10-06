<?php

namespace App\Http\Controllers\Expense\requisition;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Requisition;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class requisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $requisitions = Requisition::latest()->paginate(5);

        return view('Expense.requisition.index', compact('requisitions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Expense.requisition.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'requisition_type' => 'required',
        'requisition_date' => 'required',
        'need_by_date' => 'required',
        'employee_name' => 'required',
        'item_category' => 'required',
        'item_no' => 'required',
        'description' => 'required',
        'specification' => 'required',
        'remarks' => 'required',
        'uom' => 'required',
        'required_qty' => 'required',
        'file' => 'sometimes|mimes:pdf', // Validate the uploaded file as PDF
    ]);

    // Generate a unique requisition number
    $uniqueRequisitionNo = $this->generateUniqueRequisitionNo();

    $originalFileName = null; // Initialize $originalFileName as null

    if ($request->hasFile('file')) {
        $originalFileName = $request->file('file')->getClientOriginalName(); // Get the original file name
        $fileName = time() . '_' . $originalFileName; // Generate a unique file name
        // Store the uploaded PDF file in the "storage/app/uploads" directory
        $path = $request->file('file')->storeAs('uploads', $fileName, 'local');
    } else {
        $path = null;
    }

    $data = $request->all();
    $data['requisition_no'] = $uniqueRequisitionNo; // Set the unique requisition number
    $data['file_path'] = $path;
    $data['file_name'] = $originalFileName; // Store the original file name

    Requisition::create($data);

    return redirect()->route('requisitions.index')
        ->with('success', 'Requisition created successfully.');
}

// Custom function to generate a unique requisition number
private function generateUniqueRequisitionNo()
{
    $latestRequisition = Requisition::latest('id')->first();
    $latestRequisitionNo = $latestRequisition ? $latestRequisition->requisition_no : 'REQ00000';
    $newRequisitionNo = 'REQ' . str_pad((int)substr($latestRequisitionNo, 3) + 1, 5, '0', STR_PAD_LEFT);

    // Check if the generated requisition number already exists
    if (Requisition::where('requisition_no', $newRequisitionNo)->exists()) {
        // If it exists, recursively call the function to generate a new one
        return $this->generateUniqueRequisitionNo();
    }

    return $newRequisitionNo;
}





    
    /**
     * Display the specified resource.
     */
    public function show(Requisition $requisition): View
    {
        return view('Expense.requisition.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requisition $requisition): View
    {
        return view('Expense.requisition.edit', compact('requisition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requisition $requisition): RedirectResponse
    {
        $request->validate([
            'requisition_no' => 'required',
            'requisition_type' => 'required',
            'requisition_date' => 'required',
            'need_by_date' => 'required',
            'employee_name' => 'required',
            'item_category' => 'required',
            'item_no' => 'required',
            'description' => 'required',
            'specification' => 'required',
            'remarks' => 'required',
            'uom' => 'required',
            'required_qty' => 'required',
            'file' => 'sometimes|mimes:pdf', // Allow PDF file upload for update
        ]);
    
        if ($request->hasFile('file')) {
            // If a new PDF file is uploaded, replace the old one
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('uploads', $fileName);
            try {
                if ($requisition->file_path) {
                    // Delete the old file if it exists
                    Storage::delete($requisition->file_path);
                }
            } catch (\Exception $e) {
                // Log or handle the exception as needed
                return redirect()->back()->with('error', 'File deletion failed.');
            }
            $requisition->file_path = 'uploads/' . $fileName;
        }
    
        // Update the requisition with the new data
        $requisition->update($request->all());
    
        return redirect()->route('requisitions.index')
            ->with('success', 'Requisition updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requisition $requisition): RedirectResponse
    {
        if ($requisition->file_path) {
            // Delete the associated file
            Storage::delete($requisition->file_path);
        }

        $requisition->delete();

        return redirect()->route('requisitions.index')
            ->with('success', 'Requisition deleted successfully');
    }

    
    public function download(Request $request, $file)
{
    $requisition = Requisition::findOrFail($file);
    
    if ($requisition->file_path) {
        // Get the updated file path from the database
        $requisition = Requisition::find($requisition->id);
        $filePath = storage_path('app/' . $requisition->file_path);
    
        if (file_exists($filePath)) {
            return response()->download($filePath, $requisition->file_name);
        }
    }
    
    return redirect()->route('requisitions.index')->with('error', 'File not found.');
}

    

}
