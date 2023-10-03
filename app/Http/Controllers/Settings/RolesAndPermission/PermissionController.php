<?php

namespace App\Http\Controllers\Settings\RolesAndPermission;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        $rolesWithPermissions = Role::with('permissions')->get();
        $permissions = Permission::all(); // Retrieve all permissions
        
        return view('settings.permission.permission', compact('rolesWithPermissions'));
    }
}

