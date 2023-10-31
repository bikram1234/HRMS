<?php

namespace App\Http\Controllers\Advance\add_device_emi;
use App\Http\Controllers\Controller; // Import the Controller class

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Device_emi;



class device_emiController extends Controller
{
    public function show(){

        $device = Device_emi::all();

        return view('advance.add_device.show_device',compact('device'));

    }

    public function create(){
        return view('advance.add_device');
    }

    public function store(Request $request){
        $validate = $request-> validate([
            'type' => 'required|string',
            'amount' =>'required|numeric',

        ]);

        Device_emi :: create($validate);
        return redirect()->route('device.index')
        ->with('success','Successfully Added');
    }

    public function edit(Device_emi $device)
    {
        return view('advance.add_device.show_device', compact('device'));
    }

    public function update(Request $request, Device_emi $device)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $device->update($data);
        return redirect()->route('device.index');
    }
    public function destroy(Device_emi $device)
    {
        $device->delete();
        return redirect()->route('device.index');
    }

}