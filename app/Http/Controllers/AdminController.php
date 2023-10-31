<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseType;
use App\Models\Policy;
use App\Models\Section;
use App\Models\User;
use App\Models\ExpenseApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use App\Models\Designation;
use App\Models\Grade;
use App\Models\region;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Hash; 


class AdminController extends Controller
{   
    // Get Department for registeration
    public function getDepartments()
    {
        return Department::all();
    }

    // Get Section for registeration
    public function getSections()
    {
        return Section::all();
    }

    //View_Department
    public function addDepartmentForm()
    {
        $departments = Department::all();
        return view('admin.add_department', compact('departments'));   
    }

// ADD_Department Method
    public function addDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
    ]);

         Department::create($validatedData);

        return redirect()->route('add-department-form')
            ->with('success', 'Department added successfully.');
    }

    // Get Section 
    public function addSectionForm()
    {
        // $sections = Section::all();
        $sections = Section::paginate(10); // You can adjust the number of items per page
        $departments = Department::all();
        //ssdds
        return view('admin.add_section', compact('departments','sections'));
    }
    
    // Add Section Method
    public function addSection(Request $request)
    {
        $validatedData = $request->validate([
        'department_id' => 'required|exists:departments,id',
        'name' => 'required|string|max:255',
        ]);

        Section::create($validatedData);

        return redirect()->route('add-section-form')
            ->with('success', 'Section added successfully.');
    }

     // Get Add User form
     public function createUser()
     {
         // Get departments and sections
         $departments = Department::all();
         $sections = Section::all();
         $roles = Role::all();
         $designations = Designation::all();
         $grades = Grade::all();
         $region = region::all();
         return view('settings.systemuser.adduser', compact('departments', 'sections', 'roles', 'designations', 'grades','region'));
     }

   //  Add User Method
   public function storeUser(Request $request)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'employee_id' => 'required|unique:users,employee_id',
           'department_id' => ['required', 'exists:departments,id'], // Validate department
           'designation_id' => ['required', 'exists:designations,id'],
           'grade_id' => ['required', 'exists:grades,id'],
           'region_id' => ['required', 'exists:regions,id'],
           'gender' => ['required'],
           'employment_type' => ['required']
       ],
       [
           'employee_id.unique' => 'The employee ID must be unique.',
       ]
   );

    
        // Generate a random password
        $randomPassword = Str::random(10);
    
        // Create the user instance with the generated password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'employee_id' => $validated['employee_id'],
            'password' => Hash::make($randomPassword), // Hash the random password
            'department_id' => $request->department_id,
            'section_id' => $request->section_id,
            'designation_id' => $request->designation_id,
            'grade_id' => $request->grade_id,
            'region_id' => $request->region_id,
            'gender' => $request->gender,
            'employment_type' => $request->employment_type,
        ]);
    
        $role = Role::findOrFail($request->role); // Get the selected role by ID
        $user->assignRole($role);
        // Send email with random password
        Mail::to($user->email)->send(new UserCreatedMail($user, $randomPassword));
        //display the message 
        // dd($randomPassword);
        $notification = array(
            'message' => 'User created successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('users.create')->with($notification);
    }
    

    // Get Expense_type 
    public function showAddForm()
    {
        $expenseTypes = ExpenseType::all(); // Assuming ExpenseType is your model
        return view('admin.expensetype', compact('expenseTypes'));
    }

    //Add Expense_type Method 
    public function addExpenseType(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        // Create a new expense type
        ExpenseType::create($validatedData);

        return redirect()->route('expense-types')
            ->with('success', 'Expense type added successfully');
    }

    // Get Policy
    public function AddForm()
    {
        $expenseTypes = ExpenseType::all();
        $policies = Policy::all(); // Fetch policies from the database
        return view('admin.policy_add', compact('expenseTypes', 'policies'));
    }
    
    // Add Policy Based on Expense_Type
    public function addPolicy(Request $request)
    {
        $validatedData = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,enforce', // Add the status validation
        ]);

        Policy::create($validatedData);

        return redirect()->route('add-policy')
            ->with('success', 'Policy added successfully');
    }

    // Get the Expense Application Form
    public function showApplicationForm()
    {        
        
        $expenseTypes = ExpenseType::all();
        $user = Auth::user(); // Get the authenticated user
        $userApplications = ExpenseApplication::where('user_id', $user->id)->get(); // Fetch user's applications
        
        return view('admin.expense_form', compact('userApplications', 'expenseTypes'));
    }
    // Add expense Application Request
    public function submitApplication(Request $request)
    {
        $validatedData = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file
        ], [
            'attachment.max' => 'The attachment file size must not exceed 2MB.',
        ]);
    
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            if ($attachment->getSize() > 2048000) { // 2MB in bytes
                return redirect()->route('show-application-form')
                    ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
                    ->withInput();
            }
    
            $attachmentPath = $attachment->store('attachments', 'public');
            $validatedData['attachment'] = $attachmentPath;
        }
    
        $validatedData['user_id'] = Auth::id(); // Assign the current user's ID
        $validatedData['application_date'] = now(); // Current date
        $validatedData['status'] = 'pending'; // Set status to pending
    
        ExpenseApplication::create($validatedData);
    
        return redirect()->route('show-application-form')
            ->with('success', 'Expense application submitted successfully.');
    }
    

}


