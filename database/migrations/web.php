<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Expense\expense_type\expense_type;
use App\Http\Controllers\Expense\policy\add_policy;
use App\Http\Controllers\Expense\policy\edit_policy;
use App\Http\Controllers\Expense\expense_apply\apply;
use App\Http\Controllers\Advance\advance_type\advance_type;
use App\Http\Controllers\Advance\apply\advance_apply;
use App\Http\Controllers\Expense\dsa_claim\dsa_settlement;


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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])
->middleware(['auth', 'verified']) // Middleware list goes here, if needed
->name('home');



// Expense_Type_Route

Route::get('/expense-types', [expense_type::class, 'showAddForm'])->name('expense-types');
Route::post('/expense-types', [expense_type::class, 'addExpenseType'])->name('expense-types');

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

// Add_Advance_Type
Route::get('/admin/advance/add', [advance_type::class, 'showAdvanceForm'])->name('show-advance-form');
Route::post('/admin/advance/add', [advance_type::class, 'addAdvance'])->name('add-advance');

// Route to show the advance form
Route::get('/advance-form', [advance_apply::class, 'showAdvance'])->name('show-advance-loan');
// Route to handle the advance submission
Route::post('/Add-Advance', [advance_apply::class, 'addAdvanceLoan'])->name('Add-Advance');

// Route to display the DSA settlement form
Route::get('dsa-settlement', [dsa_settlement::class, 'dsaSettlementForm'])
    ->name('dsa-settlement-form');

// Route to calculate and display the DSA settlement
Route::post('calculate-dsa-settlement', [dsa_settlement::class, 'calculateDsaSettlement'])
    ->name('calculate-dsa-settlement');
// Route to retrive allthe dsa settlement 
Route::get('/retrieve-dsa-data', [dsa_settlement::class,'DSAretrieveData'])->name('retrieve-dsa-data');



//Department_Route
Route::get('/add-department', [AdminController::class, 'addDepartmentForm'])->name('add-department-form');
Route::post('/add-department', [AdminController::class, 'addDepartment'])->name('add-department');

//Section_Route

Route::get('/add-section', [AdminController::class, 'addSectionForm'])->name('add-section-form');
Route::post('/add-section', [AdminController::class, 'addSection'])->name('add-section');

//Grade
Route::get('/grade', [AdminController::class, 'grade'])->name('grade');
Route::post('/grade', [AdminController::class, 'create_grade'])->name('grade');

//Add_User
Route::get('/create-user', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/store-user', [AdminController::class, 'storeUser'])->name('users.store');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
