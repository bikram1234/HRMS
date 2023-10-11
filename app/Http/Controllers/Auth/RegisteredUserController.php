<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\department;
use App\Models\section;
use Spatie\Permission\Models\Role;
use App\Models\designation;
use App\Models\grade;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    protected $adminController;

    public function __construct(AdminController $adminController)
    {
        $this->adminController = $adminController;
    }

    public function create(): View
    {
        // Fetch departments and sections using the injected adminController instance
        $departments = department::all();
        $roles = role::all();
        $designations = Designation::all();
        $grades = Grade::all();
        return view('auth.register', compact('departments', 'roles', 'designations', 'grades'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }
    public function store(Request $request): RedirectResponse
    {
        try{
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'employee_id' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check if it's the first user
        if (User::count() === 0) {
            // This is the first user, create a super-admin
            $role = Role::where('name', 'super-admin')->first();
        } else {
            // This is not the first user, assign the selected role
            $role = Role::findOrFail($request->role);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'employee_id' => $request->employee_id,
            'password' => Hash::make($request->password),
        ]);

        // Assign the role to the user
        if ($role) {
            $user->assignRole($role);
        }

        return redirect()->route('login')->with('success', "Successfully Registered. Login Now!!");
        
    } catch (\Exception $e) {
        \Log::error('Error:', ['message' => $e->getMessage()]);
        return back()->withInput()
            ->with('success', 'An error occurred while adding policy Enforcement: ' . $e->getMessage());
    }
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
