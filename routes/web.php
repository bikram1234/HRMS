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
use App\Http\Controllers\WorkStructure\Geography\Country\CountryController;
use App\Http\Controllers\WorkStructure\Geography\TimeZone\TimezoneController;
use App\Http\Controllers\WorkStructure\Geography\Region\RegionController;
use App\Http\Controllers\WorkStructure\Geography\Dzongkhag\DzongkhagController;
use App\Http\Controllers\WorkStructure\Geography\StoreLocation\StorelocationController;
use App\Http\Controllers\WorkStructure\Holiday\HolidayController;
use App\Http\Controllers\WorkStructure\Holiday\HolidaytypeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Settings\RolesAndPermission\PermissionController;
use App\Http\Controllers\Settings\Hierarchy\HierarchyController;
use App\Http\Controllers\Settings\Approval\ApprovalRuleController;
use App\Http\Controllers\Settings\Approval\ApprovalConditionController;
use App\Http\Controllers\Settings\Approval\Encashment\LeaveEncashmentApprovalRuleController;
use App\Http\Controllers\Settings\Approval\Encashment\LeaveEncashmentApprovalConditionController;
use App\Http\Controllers\Settings\Formula\Encashment\LeaveEncashmentFormulaController;
use App\Http\Controllers\Encashment\Apply\AppliedEncashmentController;
use App\Http\Controllers\Encashment\Approval\EncashmenApprovalController;
use App\Http\Controllers\Settings\Formula\FormulaController;
use App\Http\Controllers\Leave\Type\LeavetypeController;
use App\Http\Controllers\Leave\Policy\LeavePolicyController;
use App\Http\Controllers\Leave\Plan\LeavePlanController;
use App\Http\Controllers\Leave\Rule\LeaveRuleController;
use App\Http\Controllers\Leave\YearEnd\LeaveYearendProcessingController;
use App\Http\Controllers\Leave\Apply\AppliedLeaveController;
use App\Http\Controllers\Leave\Approval\LeaveApprovalController;
use App\Http\Controllers\NoDue\NoDueRequestController;
use App\Http\Controllers\Nodue\NoDueRequestApprovalController;


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

// Route::get('/home', [HomeController::class, 'index'])
// ->middleware(['auth', 'verified']) // Middleware list goes here, if needed
// ->name('home');

Route::get('/login', [AuthController::class, 'login'])->name(name:'login');
Route::post('/login', [AuthController::class, 'loginPost'])->name(name:'login.post');

Route::get('/register', [RegisteredUserController::class, 'register'])->name(name:'register');
Route::post('/registerUser', [RegisteredUserController::class, 'store'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name(name:'logout');

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

    Route::get('/country', [CountryController::class, 'index'])->name('country.index');
    Route::post('/addCountry', [CountryController::class, 'store'])->name('country.store');
    Route::patch('/updateCountry/{country}', [CountryController::class, 'update'])->name('country.update');
    Route::delete('/delete/{country}', [CountryController::class, 'destroy'])->name('country.delete');

    Route::get('/timezone', [TimezoneController::class, 'index'])->name('timezone.index');
    Route::post('/timezoneAdd', [TimezoneController::class, 'store'])->name('timezone.store');
    Route::patch('/updateTimezone/{timezone}', [TimezoneController::class, 'update'])->name('timezone.update');
    Route::delete('/deletetimezone/{timezone}', [TimezoneController::class, 'destroy'])->name('timezone.delete');

    Route::get('/region', [RegionController::class, 'index'])->name('region.index');
    Route::post('/addRegion', [RegionController::class, 'store'])->name('region.store');
    Route::patch('/updateRegion/{region}', [RegionController::class, 'update'])->name('region.update');
    Route::delete('/deleteRegion/{region}', [RegionController::class, 'destroy'])->name('region.delete');

    Route::get('/dzongkhag', [DzongkhagController::class, 'index'])->name('dzongkhag.index');
    Route::get('/get-regions/{countryId}', [DzongkhagController::class, 'getRegions'])->name('getRegions');
    Route::post('/addDzongkhag', [DzongkhagController::class, 'store'])->name('dzongkhag.store');
    Route::patch('/updateDzongkhag/{dzongkhag}', [DzongkhagController::class, 'update'])->name('dzongkhag.update');
    Route::delete('/deleteDzongkhag/{dzongkhag}', [DzongkhagController::class, 'destroy'])->name('dzongkhag.delete');

    Route::get('/storelocation', [StorelocationController::class, 'index'])->name('storelocation.index');
    Route::post('/addStorelocation', [StorelocationController::class, 'store'])->name('storelocation.store');
    Route::delete('/delete/{storelocation}', [StorelocationController::class, 'destroy'])->name('storelocation.delete');
    Route::patch('/update/{storelocation}', [StorelocationController::class, 'update'])->name('storelocation.update');

    Route::get('/holiday', [HolidayController::class, 'index'])->name('holiday.index');
    Route::post('/Addholiday', [HolidayController::class, 'store'])->name('holiday.store');
    Route::get('/fetch-holiday-dates', [HolidayController::class, 'fetchHolidayDates'])->name('fetch-holiday-dates');

    Route::post('/holidaytype', [HolidaytypeController::class, 'store'])->name('holidaytype.store');

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
    Route::post('/approval', [ApprovalRuleController::class, 'store'])->name('approval.leave.store');
    Route::get('/approval/{approvalRule}', [ApprovalRuleController::class, 'show'])->name('approval.show');
    Route::patch('/approval/{approvalRule}', [ApprovalRuleController::class, 'update'])->name('approval.update');
    Route::get('/fetch-types/{for}', [ApprovalRuleController::class, 'fetchTypes'])->name('fetch-types');

    Route::get('/approvalEncashment', [LeaveEncashmentApprovalRuleController::class, 'index'])->name('encashment_approvalRule.index');
    Route::post('/encashmentApprovalRule', [LeaveEncashmentApprovalRuleController::class, 'store'])->name('approval.encashment.store');
    Route::get('/approvalEncashment/{leaveEncashmentApprovalRule}', [LeaveEncashmentApprovalRuleController::class, 'show'])->name('approval_encashment.show');

    Route::get('/condition/{approval_rule_id}', [ApprovalConditionController::class, 'create'])->name('condition.create');
    Route::post('/condition', [ApprovalConditionController::class, 'store'])->name('condition.store');
    Route::get('/approval_condition/{approval_condition}/edit', [ApprovalConditionController::class, 'edit'])->name('approval_condition.edit');
    Route::patch('/condition/{approval_condition}', [ApprovalConditionController::class, 'update'])->name('condition.update');

    Route::get('/encashmenCondition/{encashment_approval_rule_id}', [LeaveEncashmentApprovalConditionController::class, 'create'])->name('encashment_condition.create');
    Route::post('/encashmenCondition', [LeaveEncashmentApprovalConditionController::class, 'store'])->name('encashment_condition.store');
    Route::get('/encashment_approval_condition/{leaveEncashmentApprovalCondition}/edit', [LeaveEncashmentApprovalConditionController::class, 'edit'])->name('encashment_approval_condition.edit');    
    Route::patch('/encashment_condition/{leaveEncashmentApprovalCondition}', [LeaveEncashmentApprovalConditionController::class, 'update'])->name('encashment_condition.update');
    
    Route::get('/formula/create-for-encashment-approval-condition/{encashmentApprovalConditionId}', [LeaveEncashmentFormulaController::class, 'createForEncashmentApprovalCondition'])
    ->name('formula.createForEncashmentApprovalCondition');
    Route::post('/formulaEncashment', [LeaveEncashmentFormulaController::class, 'store'])->name('encashment_formula.store');
    Route::delete('/encashment-formuala/{leaveEncashmentFormula}', [LeaveEncashmentFormulaController::class, 'destroy'])->name('encashment_formula.delete');

 
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

    Route::get('/leaveHistory', [AppliedLeaveController::class, 'index'])->name('leave.history')->middleware('auth');;
    Route::get('/fetch-leave-balance/{leaveTypeId}', [AppliedLeaveController::class, 'fetchLeaveBalance'])->name('fetch.leave.balance')->middleware('auth');;
    Route::get('/apply-leave', [AppliedLeaveController::class, 'create'])->name('leaveapply.create')->middleware('auth');;
    Route::post('/apply-leave', [AppliedLeaveController::class, 'store'])->name('applyleave.store')->middleware('auth');;
    Route::get('/fetch-include-weekends/{leaveTypeId}', [AppliedLeaveController::class, 'fetchIncludeWeekends'])->name('fetch-include-weekends');
    Route::get('/fetch-include-public-holidays/{leaveTypeId}', [AppliedLeaveController::class, 'fetchIncludePublicHolidays'])->name('fetch-include-public-holidays');
    Route::get('/fetch-can-be-half-day/{leaveTypeId}', [AppliedLeaveController::class, 'fetchCanBeHalfDay'])->name('fetch-can-be-half-day');

    Route::get('/leaveApproval', [LeaveApprovalController::class, 'index'])->name('leaveApproval.index');
    Route::post('/leave-approval/{id}', [LeaveApprovalController::class, 'approveLeave'])->name('leave.approve');
    Route::post('/leave-decline/{id}', [LeaveApprovalController::class, 'declineLeave'])->name('leave.decline');
    Route::post('/leave-cancel/{id}', [LeaveApprovalController::class, 'cancelLeave'])->name('leave.cancel');
    
});

Route::namespace('NoDue')->group(function () {
    Route::get('/nodue',[NoDueRequestController::class, 'index'])->name('nodue.index');
    Route::post('/nodue', [NoDueRequestController::class, 'create'])->name('nodue.create');
    Route::get('nodueApproval', [NoDueRequestApprovalController::class, 'index'])->name('nodueapproval.index');
    Route::get('/approve/{id}', [NoDueRequestApprovalController::class, 'approve'])->name('nodue.approve');
});

Route::namespace('Encashment')->group(function () {
    Route::post('/leave-encashment', [AppliedEncashmentController::class, 'store'])->name('encashment.store');
    Route::post('/encashment-approval/{id}', [EncashmenApprovalController::class, 'approveEncashment'])->name('encashment.approve')->middleware('auth');
    Route::post('/encashment-decline/{id}', [EncashmenApprovalController::class, 'declineEncashment'])->name('encashment.decline')->middleware('auth');

    Route::get('/encashmentApproval',[EncashmenApprovalController::class, 'index'])->name('encashment_approval.index')->middleware('auth');;
    Route::post('/nodue', [NoDueRequestController::class, 'create'])->name('nodue.create')->middleware('auth');
    Route::get('nodueApproval', [NoDueRequestApprovalController::class, 'index'])->name('nodueapproval.index')->middleware('auth');
    Route::get('/approve/{id}', [NoDueRequestApprovalController::class, 'approve'])->name('nodue.approve')->middleware('auth');
});



//Add_User
Route::get('/create-user', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/store-user', [AdminController::class, 'storeUser'])->name('users.store');

Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');

require __DIR__.'/auth.php';
