<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkStructure\Department\DepartmentController;
use App\Http\Controllers\WorkStructure\Section\SectionController; 
use App\Http\Controllers\WorkStructure\Role\RoleController;
use App\Http\Controllers\WorkStructure\Designation\DesignationController;
use App\Http\Controllers\WorkStructure\Grade\GradeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Settings\RolesAndPermission\PermissionController;
use App\Http\Controllers\Settings\Hierarchy\HierarchyController;
use App\Http\Controllers\Settings\Approval\ApprovalRuleController;
use App\Http\Controllers\Settings\Approval\ApprovalConditionController;
use App\Http\Controllers\Settings\Formula\FormulaController;
use App\Http\Controllers\Leave\Type\LeavetypeController;
use App\Http\Controllers\Leave\Policy\LeavePolicyController;
use App\Http\Controllers\Leave\Plan\LeavePlanController;
use App\Http\Controllers\Leave\Rule\LeaveRuleController;
use App\Http\Controllers\Leave\YearEnd\LeaveYearendProcessingController;
use App\Http\Controllers\Leave\Apply\AppliedLeaveController;
use App\Http\Controllers\Expense\expense_type\expense_type;
use App\Http\Controllers\Expense\policy\add_policy;
use App\Http\Controllers\Expense\policy\edit_policy;
use App\Http\Controllers\Expense\expense_apply\apply;
use App\Http\Controllers\Expense\expense_approval\expense_approval_Controller;
use App\Http\Controllers\Advance\advance_type\advance_type;
use App\Http\Controllers\Advance\apply\advance_apply;
use App\Http\Controllers\Advance\advance_approval\advance_approval_Controller;
use App\Http\Controllers\Expense\dsa_claim\dsa_settlement;
use App\Http\Controllers\Expense\dsa_approval\dsa_approval_Controller;
use App\Http\Controllers\Expense\expense_fuel\fuel_claim;
use App\Http\Controllers\Expense\Fuel_approval\fuel_approval_Controller;
use App\Http\Controllers\Expense\transfer_claim\transfer_claim;
use App\Http\Controllers\Expense\transfer_claim_approval\transfer_claim_approval_Controller;
use App\Http\Controllers\Expense\requisition\requisitionController;
use App\Http\Controllers\WorkStructure\basic_pay\basic_payController;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->get('/', function () {
    return view('welcome');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])
->middleware(['auth', 'verified']) // Middleware list goes here, if needed
->name('home');

Route::get('/login', [AuthController::class, 'login'])->name(name:'login');
Route::post('/login', [AuthController::class, 'loginPost'])->name(name:'login.post');

Route::get('/register', [RegisteredUserController::class, 'register'])->name(name:'register');
Route::post('/registerUser', [RegisteredUserController::class, 'store'])->name('register.post');
Route::get('/logout', [RegisteredUserController::class, 'logout'])->name(name:'logout');

//Route for WorkStructure
Route::namespace('WorkStructure')->group(function () {
    // Designation routes
    Route::get('/designation', [DesignationController::class, 'index'])->name('designation.index');
    Route::get('/add-designation', [DesignationController::class, 'create'])->name('designation.create');
    Route::post('/designation', [DesignationController::class, 'store'])->name('designation.store');
    Route::get('/designation/{designation}/edit', [DesignationController::class, 'edit'])->name('designation.edit');
    Route::patch('/designation/{designation}', [DesignationController::class, 'update'])->name('designation.update');
    Route::delete('/designation/{designation}', [DesignationController::class, 'destroy'])->name('designation.delete');

    // Department routes
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/adddepartment', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/{department}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::patch('/department/{department}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/{department}', [DepartmentController::class, 'destroy'])->name('department.delete');

    Route::get('/section', [SectionController::class, 'index'])->name('section.index');
    Route::get('/addsection', [SectionController::class, 'create'])->name('section.create');
    Route::post('/section', [SectionController::class, 'store'])->name('section.store');
    Route::get('/section/{section}/edit', [SectionController::class, 'edit'])->name('section.edit');
    Route::patch('/section/{section}', [SectionController::class, 'update'])->name('section.update');
    Route::delete('/section/{section}', [SectionController::class, 'destroy'])->name('section.delete');
    Route::get('/sections/{department}', [SectionController::class, 'getSectionsByDepartment'])->name('sections.getSectionsByDepartment');

    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/addrole', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::patch('/role/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.delete');

    Route::get('/grade', [GradeController::class, 'index'])->name('grade.index');
    Route::get('/add-grade', [GradeController::class, 'create'])->name('grade.create');
    Route::post('/grade', [GradeController::class, 'store'])->name('grade.store');
    Route::get('/grade/{grade}/edit', [GradeController::class, 'edit'])->name('grade.edit');
    Route::patch('/grade/{grade}', [GradeController::class, 'update'])->name('grade.update');
    Route::delete('/grade/{grade}', [GradeController::class, 'destroy'])->name('grade.delete');

});

Route::namespace('Settings')->group(function () {
    Route::get('/hierarchy',[HierarchyController::class, 'index'])->name('hierarchy.index');
    Route::get('/hierarchyAdd', [HierarchyController::class, 'create'])->name('hierarchy.create');
    Route::post('/hierarchy', [HierarchyController::class, 'store'])->name('hierarchy.store');
    Route::get('/hierarchy/{hierarchy_id}', [HierarchyController::class, 'show'])->name('hierarchy.show');
    Route::post('/level/{hierarchyId}', [HierarchyController::class, 'storeLevel'])->name('level.store');  
    Route::get('/hierarchy/{hierarchy}/edit', [HierarchyController::class, 'edit'])->name('hierarchy.edit');
    Route::patch('/hierarchy/{hierarchy}', [HierarchyController::class, 'update'])->name('hierarchy.update');
    Route::delete('/hierarchy/{hierarchy}', [HierarchyController::class, 'delete'])->name('hierarchy.delete');
    Route::get('/levels/{hierarchyId}', [HierarchyController::class, 'getLevels']);

    Route::get('/approval', [ApprovalRuleController::class, 'index'])->name('approval.index');
    Route::get('/approvalAdd', [ApprovalRuleController::class, 'create'])->name('approval.create');
    Route::post('/approval', [ApprovalRuleController::class, 'store'])->name('approval.store');
    Route::get('/approval/{approvalRule}', [ApprovalRuleController::class, 'show'])->name('approval.show');
    Route::patch('/approval/{approvalRule}', [ApprovalRuleController::class, 'update'])->name('approval.update');
    Route::get('/fetch-types/{for}', [ApprovalRuleController::class, 'fetchTypes'])->name('fetch-types');


    Route::get('/condition/{approval_rule_id}', [ApprovalConditionController::class, 'create'])->name('condition.create');
    Route::post('/condition', [ApprovalConditionController::class, 'store'])->name('condition.store');
    Route::get('/approval_condition/{approval_condition}/edit', [ApprovalConditionController::class, 'edit'])->name('approval_condition.edit');
    Route::patch('/condition/{approval_condition}', [ApprovalConditionController::class, 'update'])->name('condition.update');

    Route::get('/formula/create-for-approval-condition/{approvalConditionId}', [FormulaController::class, 'createForApprovalCondition'])
    ->name('formula.createForApprovalCondition');
    Route::post('/formula', [FormulaController::class, 'store'])->name('formula.store');
    Route::delete('/formula/{formula}', [FormulaController::class, 'destroy'])->name('formula.delete');

});


Route::namespace('Leave')->group(function () {
    Route::get('/leavetype',[LeavetypeController::class, 'index'])->name('leavetype.index');
    Route::get('/leavetypeAdd', [LeavetypeController::class, 'create'])->name('leavetype.create');
    Route::post('/leavetype', [LeavetypeController::class, 'store'])->name('leavetype.store');
    Route::get('/leavetype/{leavetype}/edit', [LeavetypeController::class, 'edit'])->name('leavetype.edit');
    Route::patch('/leavetype/{leavetype}', [LeavetypeController::class, 'update'])->name('leavetype.update');  

    
    Route::get('/leavepolicy', [LeavePolicyController::class, 'index'])->name('leavepolicy.index');
    Route::get('/leavepolicyAdd', [LeavePolicyController::class, 'create'])->name('leavepolicy.create');
    Route::post('/leavepolicy', [LeavePolicyController::class, 'store'])->name('leavepolicy.store');

    Route::get('/leaveplan/{leave_id}', [LeavePlanController::class, 'create'])->name('leaveplan.create');
    Route::post('/leaveplanAdd', [LeavePlanController::class, 'store'])->name('leaveplan.store');
    Route::post('/leaveruleAdd', [LeaveRuleController::class, 'store'])->name('leaverule.store');


    Route::get('/yearendAdd/{leave_id}', [LeaveYearendProcessingController::class, 'create'])->name('yearendprocessing.create');
    Route::post('/yearendprocessing', [LeaveYearendProcessingController::class, 'store'])->name('yearendprocessing.store');
    Route::get('/summary/{leave_id}', [LeaveYearendProcessingController::class, 'showSummary'])->name('showSummary.show');
    Route::get('/deleteLeaveData/{leave_id}', [LeaveYearendProcessingController::class, 'deleteLeaveData'])->name('deleteLeaveData');
    Route::get('/saveNow/{leave_id}', [LeaveYearendProcessingController::class, 'saveNow'])->name('saveNow');
    Route::get('/viewSummary/{leave_id}', [LeaveYearendProcessingController::class, 'leavePolicyView'])->name('leavePolicy.view');

    Route::get('/leaveHistory', [AppliedLeaveController::class, 'index'])->name('leave.history');
    Route::get('/fetch-leave-balance/{leaveTypeId}', [AppliedLeaveController::class, 'fetchLeaveBalance'])->name('fetch.leave.balance');
    Route::get('/apply-leave', [AppliedLeaveController::class, 'create'])->name('leaveapply.create');
    Route::post('/apply-leave', [AppliedLeaveController::class, 'store'])->name('applyleave.store');
    Route::get('/fetch-include-weekends/{leaveTypeId}', [AppliedLeaveController::class, 'fetchIncludeWeekends'])->name('fetch-include-weekends');

    
});


//DSA Route
// Expense_Type_Route
Route::get('/expense-types', [expense_type::class, 'showAddForm'])->name('expense-types');
Route::post('/expense-types', [expense_type::class, 'addExpenseType'])->name('expense-types');
//Edit Expense Type
Route::get('/expense-types/{id}/edit', [expense_type::class,'edit'])->name('expense-types.edit');
Route::put('/expense-types/{id}', [expense_type::class,'update'])->name('expense-types.update');



//Policy Route
Route::get('/add-policy', [add_policy::class, 'AddForm'])->name('add-policy');
Route::post('/add-policy', [add_policy::class, 'addPolicy'])->name('add-policy');

//Rate Definition
Route::get('/rate-definition/{policy}', [add_policy::class, 'addRateDefinition'])->name('add-rate-definition');
Route::post('/rate-definition', [add_policy::class, 'storeRateDefinition'])->name('store-rate-definition');

// Rate Limit
Route::get('rate-definitions/{rateDefinition}/rate-limits/create', [add_policy::class, 'createLimit'])->name('rate-limits.create');
Route::post('rate-definitions/{rateDefinition}/rate-limits', [add_policy::class, 'storeLimit'])->name('rate-limits.store');

// Policy Enfrocement
Route::get('/policy-enforcement/{policy}', [add_policy::class,'policyEnforcement'])->name('policy-enforcement.index');
Route::post('/policy-enforcement/{policy}', [add_policy::class, 'storepolicyEnforement'])->name('policy-enforcement.store');

//get Create_Policy_Route
Route::get('/policy/{policy}/create', [add_policy::class, 'createpolicy'])->name('policy.details.create');
Route::post('/policy/{policy}/save-or-cancel', [add_policy::class, 'saveorcanclepolicy'])->name('policy.details.saveOrCancel');

//Edit Policy
Route::get('/edit-policy/{policy}', [edit_policy::class, 'editPolicy'])->name('edit-policy');
Route::put('/update-policy/{policy}', [edit_policy::class,'updatePolicy'])->name('update-policy');

//Edit Rate definition
Route::get('/edit-rate-definition/{policy}', [edit_policy:: class, 'editRateDefinition'])->name('edit-rate-definition');
Route::put('/update-rate-definition/{policy}', [edit_policy:: class, 'updateRateDefinition'])->name('update-rate-definition');
// Rate Limit after update of rate defintion
Route::get('rate-limit/{rateDefinition}/rate-limits/create', [edit_policy::class, 'createLimits'])->name('edit-rate-limits.create');
Route::post('rate-limit/{rateDefinition}/rate-limits', [edit_policy::class, 'storeLimits'])->name('new-rate-limits.store');

//Edit Rate limit
Route::get('/edit-rate-limit/{rateLimit}', [edit_policy:: class, 'editRateLimit'])->name('edit-rate-limit');
Route::put('/update-rate-limit/{rateLimit}', [edit_policy:: class,'updateRateLimit'])->name('update-rate-limit');

//Edit Policy Enforcement
Route::get('/edit-policy-enforcement/{policy}', [edit_policy:: class,'editPolicyEnforcement'])->name('edit-policy-enforcement');
Route::post('/update-policy-enforcement/{policy}', [edit_policy:: class,'updatePolicyEnforcement'])->name('update-policy-enforcement');

//Update the policy(Summary)
Route::get('/policy/{policy}/summary', [edit_policy::class, 'getPolicySummary'])->name('policy.summary');
Route::post('/policy/{policy}/summary', [edit_policy::class, 'postPolicySummary'])->name('policy.summary.saveOrCancel');

//Apply_Expense_Route
Route::get('/apply-expense', [apply::class, 'showApplicationForm'])
    ->name('show-application-form');
Route::post('/apply-expense', [apply::class, 'submitApplication'])
    ->name('submit-application');

//Expense_Approval Route
Route::get('/expense-approval', [expense_approval_Controller::class,'show_pending_expense_application'])->name('expense.approval.index');


// Add_Advance_Type
Route::get('/admin/advance/add', [advance_type::class, 'showAdvanceForm'])->name('show-advance-form');
Route::post('/admin/advance/add', [advance_type::class, 'addAdvance'])->name('add-advance');

// Route to show the advance form
Route::get('/advance-details', [advance_apply::class, 'advance_details'])->name('show-advance-details');
Route::get('/advance-form', [advance_apply::class, 'showAdvance'])->name('show-advance-loan');
// Route to handle the advance submission
Route::post('/Add-Advance', [advance_apply::class, 'addAdvanceLoan'])->name('Add-Advance');


//Advance Approval Route
Route::get('/advance-approval', [advance_approval_Controller::class, 'advance_approval_show'])
    ->name('advance.approval.index');


// Route to display the DSA settlement form
Route::get('dsa-settlement', [dsa_settlement::class, 'dsaSettlementForm'])
    ->name('dsa-settlement-form');

// Route to calculate and display the DSA settlement
Route::post('calculate-dsa-settlement', [dsa_settlement::class, 'calculateDsaSettlement'])
    ->name('calculate-dsa-settlement');
// Route to retrive allthe dsa settlement 
Route::get('/retrieve-dsa-data', [dsa_settlement::class,'DSAretrieveData'])->name('retrieve-dsa-data');


//Dsa Approval Route
Route::get('/dsa-approval', [dsa_approval_Controller::class,'show_dsa_approval_application'])->name('dsa.approval.index');
Route::get('/dsa-settlement/{id}', [dsa_approval_Controller::class, 'view_DsaSettlement_detail'])
    ->name('dsa-settlement.view'); 



// Show all fuels
Route::get('fuels', [fuel_claim::class, 'index'])->name('fuels.index');

// Display the form to create a new fuel
Route::get('fuels/create', [fuel_claim::class, 'create'])->name('fuels.create');

// Store a newly created fuel
Route::post('fuels', [fuel_claim::class, 'store'])->name('fuels.store');

// Display the form to edit a fuel
Route::get('fuels/{fuel}/edit', [fuel_claim::class, 'edit'])->name('fuels.edit');

// Update a fuel
Route::put('fuels/{fuel}', [fuel_claim::class, 'update'])->name('fuels.update');

//show a fuel
// Show a single fuel claim
Route::get('fuels/{fuel}', [fuel_claim::class, 'show'])->name('fuels.show');

// Delete a fuel
Route::delete('fuels/{fuel}', [fuel_claim::class, 'destroy'])->name('fuels.destroy');

//Fuel Approval Route
Route::get('/fuel-approval', [fuel_approval_Controller::class, 'fuel_approval'])
    ->name('fuel.approval.index');



// Show all products
Route::get('products', [transfer_claim::class, 'index'])->name('products.index');

// Display the form to create a new product
Route::get('products/create', [transfer_claim::class, 'create'])->name('products.create');

// Store a newly created product
Route::post('products', [transfer_claim::class, 'store'])->name('products.store');

// Display the form to edit a product
Route::get('products/{product}/edit', [transfer_claim::class, 'edit'])->name('products.edit');

// Update a product
Route::put('products/{product}', [transfer_claim::class, 'update'])->name('products.update');

// Delete a product
Route::delete('products/{product}', [transfer_claim::class, 'destroy'])->name('products.destroy');

// Show a single fuel claim
Route::get('products/{product}', [transfer_claim::class, 'show'])->name('products.show');

//transfer Approval Route
Route::get('/transfer-approval', [transfer_claim_approval_Controller::class, 'transfer_claim_approval_show'])
    ->name('transfer.approval.index');



// Show all requisitions
Route::get('requisitions', [RequisitionController::class, 'index'])->name('requisitions.index');

// Display the form to create a new requisition
Route::get('requisitions/create', [RequisitionController::class, 'create'])->name('requisitions.create');

// Store a newly created requisition
Route::post('requisitions', [RequisitionController::class, 'store'])->name('requisitions.store');

// Display the form to edit a requisition
Route::get('requisitions/{requisition}/edit', [RequisitionController::class, 'edit'])->name('requisitions.edit');

// Update a requisition
Route::put('requisitions/{requisition}', [RequisitionController::class, 'update'])->name('requisitions.update');

// Show a single requisition
Route::get('requisitions/{requisition}', [RequisitionController::class, 'show'])->name('requisitions.show');

// Delete a requisition
Route::delete('requisitions/{requisition}', [RequisitionController::class, 'destroy'])->name('requisitions.destroy');
// Download a requisition
Route::get ('requisitions/download/{file}', [RequisitionController::class,'download'])->name('requisitions.download');


//Add Basic
Route::get('/basic_pay', [basic_payController::class, 'index'])->name('basic_pay.index');
Route::get('/basic_pay/create', [basic_payController::class, 'create'])->name('basic_pay.create');
Route::post('/basic_pay', [basic_payController::class, 'store'])->name('basic_pay.store');

// Edit and Update
Route::get('/basic_pay/{basicPay}/edit', [basic_payController::class, 'edit'])->name('basic_pay.edit');
Route::put('/basic_pay/{basicPay}', [basic_payController::class, 'update'])->name('basic_pay.update');

// Delete
Route::get('/basic_pay/{basicPay}/confirm-delete', [basic_payController::class, 'confirmDelete'])->name('basic_pay.confirm_delete');
Route::delete('/basic_pay/{basicPay}', [basic_payController::class, 'destroy'])->name('basic_pay.destroy');



//Add_User
Route::get('/create-user', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/store-user', [AdminController::class, 'storeUser'])->name('users.store');

Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
