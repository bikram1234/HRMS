<?php

namespace App\Http\Controllers\Expense\Add_Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;

class add_vehicle_Controller extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('expense.add_vehicle.create_vehicle', compact('vehicles'));
    }

    public function create()
    {
        return view('expense.add_vehicle.create_vehicle');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|string',
            'vehicle_mileage' => 'required|numeric',
        ]);

        Vehicle::create($data);
        return redirect()->route('vehicles.index');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('expense.add_vehicle.create_vehicle', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|string',
            'vehicle_mileage' => 'required|numeric',
        ]);

        $vehicle->update($data);
        return redirect()->route('vehicles.index');
    }
}
