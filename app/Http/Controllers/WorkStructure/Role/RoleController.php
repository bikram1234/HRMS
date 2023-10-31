<?php

namespace App\Http\Controllers\WorkStructure\Role;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreroleRequest;
use App\Http\Requests\UpdateroleRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('read: role')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = role::all();
        return view('settings.role.role', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create: role')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('settings.role.role');    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreroleRequest $request)
    {
        if (!Gate::allows('create: role')) {
            abort(403, 'Unauthorized action.');
        }

        Role::create($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Role Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }
    /**
     * Display the specified resource.
     */
    public function show(role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(role $role)
    {
        if (!Gate::allows('update: role')) {
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all(); // Retrieve all permissions
        $role->load('permissions');

        return view('settings.role.roleEdit', compact('role', 'permissions'));
    
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (!Gate::allows('update: role')) {
            abort(403, 'Unauthorized action.');
        }
    
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);
    
        $role->update($request->all());
    
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions); // Sync selected permissions with the role
        //display the message 
        $notification = array(
            'message' => 'Role Updated successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('role.index')->with($notification);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $role)
    {
        if (!Gate::allows('delete: role')) {
            abort(403, 'Unauthorized action.');
        }

        $role->delete();
        //display the message 
        $notification = array(
            'message' => 'Role Deleted successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('role.index')->with($notification);
    }
}
