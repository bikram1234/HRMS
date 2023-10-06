<?php

namespace App\Http\Controllers\Expense\expense_fuel;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Fuel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

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
        return view('Expense.Fuels.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'employee_name' => 'required', // Update the validation rules
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
        ]);
        
        Fuel::create($request->all()); // Change from 'Product' to 'Fuel'
         
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
