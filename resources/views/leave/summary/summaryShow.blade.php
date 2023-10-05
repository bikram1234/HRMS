@extends('layouts.index')
@section('content')
<style>
 .status-button {
background-color:#17c964;
 border-radius: 30px;
}

.status-button:hover{
    background-color:#17c964;
}
.inactive-button {
background-color:#f5a524;
 border-radius: 30px;
}

.inactive-button:hover{
    background-color:#f5a524;
}

.icon-spacing {
    margin-left: 10px; /* Adjust the value to control the spacing */
    display: inline-block; /* Ensures the span takes up space */
}

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Leave Type</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Leave Management/Leave Type</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
						<a href="{{route('role.create')}}" class="btn add-btn" data-toggle="modal" data-target="#add_leave_type"><i class="fa fa-plus"></i>Add Leave Type</a>
						</div>
                        <div class="col-auto float-right ml-auto">
                                <div class="view-icons">
									<a href="projects.html" class="btn btn-link border-2 border-solid border-secondary"><i class="bi bi-file-earmark-excel h3"></i></a>
									<a href="project-list.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-filetype-csv h3"></i></a>
                                    <a href="projects.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-file-pdf h3"></i></a>
									<a href="project-list.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-printer h3"></i></a>
								</div>
						</div>

                    </div>
                </div>
                <!-- /Page Header -->
                
        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
            <!-- =====================================================SUMMARY========================================================== -->
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                        <div class="card tab-box">
                                        <div class="row user-tabs">
                                            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                                <ul class="nav nav-tabs nav-tabs-bottom">
                                                    <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Leave Policy</a></li>
                                                    <li class="nav-item"><a href="" data-toggle="tab" class="nav-link">Leave Plan</a></li>
                                                    <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Year End Processing</a></li>
                                                    <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link active">Summary</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                        <!--======================== Leave Policy ============================-->
                                        <div id="divleavepolicy">
                                            <h4>Leave Policy</h4>
                                            
                                            <div class="row mt-4">
                                                <span class="col-sm-3"><label for="policy_name">Policy Name:</label></span>
                                                <div class="col-sm-9">
                                                <input type="text" class="form-control" id="policy_name" name="policy_name" value="{{ $leavePolicy->policy_name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <span class="col-sm-3"><label for="policy_description">Policy Description:</label></span>
                                                <div class="col-sm-9">
                                                <textarea class="form-control" id="policy_description" name="policy_description" readonly>{{ $leavePolicy->policy_description }}</textarea>
                                            </div>
                                            <div class="row mt-4">
                                                <span class="col-sm-3"> <label for="gender">Gender:</label></span>
                                                <div class="col-sm-9">
                                                <select name="gender" id="gender" class="form-control" disabled>
                                                    <option value="M" {{ $leavePlan->gender === 'M' ? 'selected' : '' }}>Male</option>
                                                    <option value="F" {{ $leavePlan->gender === 'F' ? 'selected' : '' }}>Female</option>
                                                    <option value="A" {{ $leavePlan->gender === 'A' ? 'selected' : '' }}>All</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <span class="col-sm-3"><label for="start_date">Start Date:</label></span>
                                                <div class="col-sm-9">
                                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $leavePolicy->start_date }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                            <span class="col-sm-3"> <label for="end_date">End Date:</label></span>
                                                <div class="col-sm-9">
                                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $leavePolicy->end_date }}" readonly>
                                                </div>
                                            </div>
                                            <!-- <div class="row mt-4">
                                                <span class="col-sm-3">Status</span>
                                                <div class="col-sm-9">
                                                <input type="text" name="status" id="status" class="form-control" value="{{ $leavePolicy->end_date }}" readonly>
                                                </div>
                                            </div> -->

                                            <div class="row mt-4">
                                                <span class="col-sm-3">Is Information Only</span>
                                                <div class="col-sm-9">
                                                <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--====================== End Leave Policy============================ -->


                                        <!-- ========================LEAVE PLAN============================================= -->
                                        <div id="divleavepolicy mt-3">
                                            <h4>Leave Plan</h4>
                                            <div class="row">
                                                <span class="col-sm-3"><label for="attachement_required">Attachement Required</label></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="attachment_required" name="attachment_required" value="1" {{ $leavePlan->attachment_required ? 'checked' : '' }} disabled>
                                                </div>
                                            </div>
                                          
                                            <div class="row">
                                                <span class="col-sm-3">Leave Year</span>
                                                <div class="col-sm-9">
                                                    <div id="leavetype" class="cmplitetexalign">Calendar Year</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="col-sm-3">Credit Frequency</span>
                                                <div class="col-sm-9">
                                                    <div id="leavetype" class="cmplitetexalign">Yearly</div>
                                                </div>
                                            </div>
                                           
                                            <div class="row mt-4">
                                                <span class="col-sm-3">Leave Limits</span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="attachment_required" name="include_public_holidays" value="1" {{ $leavePlan->include_public_holidays ? 'checked' : '' }} disabled>
                                                <span>Include Public Holidays</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="attachment_required" name="include_weekends" value="1" {{ $leavePlan->include_weekends    ? 'checked' : '' }} disabled>
                                                <span>Include Weekends</span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="can_be_clubbed_with_el" name="can_be_clubbed_with_el" value="1" {{ $leavePlan->can_be_clubbed_with_el    ? 'checked' : '' }} disabled>
                                                <span>Can be Clubbed with el</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="can_be_clubbed_with_cl" name="can_be_clubbed_with_cl" value="1" {{ $leavePlan->can_be_clubbed_with_cl    ? 'checked' : '' }} disabled>
                                                <span>Can be Clubbed with cl</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="can_be_half_day" name="can_be_half_day" value="1" {{ $leavePlan->can_be_half_day    ? 'checked' : '' }} disabled>
                                                <span>Can be Half Day</span>
                                                </div>
                                            </div>
                                    
                                            <div class="row mt-4">
                                                <span class="col-sm-3">Can Avail In</span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="probation_period" name="probation_period" value="1" {{ $leavePlan->probation_period    ? 'checked' : '' }} disabled>
                                                <span>Probation Period</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="regular_period" name="regular_period" value="1" {{ $leavePlan->regular_period    ? 'checked' : '' }} disabled>
                                                <span>Regular Period</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="contact_period" name="contact_period" value="1" {{ $leavePlan->contact_period    ? 'checked' : '' }} disabled>
                                                <span>Contract Period</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="col-sm-3"></span>
                                                <div class="col-sm-9">
                                                <input type="checkbox" id="notice_period" name="notice_period" value="1" {{ $leavePlan->notice_period    ? 'checked' : '' }} disabled>
                                                <span>Notice Period</span>
                                                </div>
                                            </div>

                                <!-- =================================TABLE====================================== -->
                                    <div class="row mt-4">
                                        <h3>Leave Rule</h3>
                                            <div class="col-md-12 stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="col-md-12">
                                                            <div class="container table-responsive">  
                                                                <table id="example" class="table table-striped custom-table" style="width: 100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 30px;">
                                                                        <label>
                                                                        <input type="checkbox" id="selectAllCheckbox">
                                                                    <span>SI</span>
                                                                    </label>
                                                                    </th>
                                                                        <th>ID</th>
                                                                        <th>Grade</th>
                                                                        <th>Duration</th>
                                                                        <th>UOM</th>
                                                                        <th>Start Date</th>
                                                                        <th>End Date</th>
                                                                        <th>Is Loss of Pay</th>
                                                                        <th>Employement</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($leaveRules as $key => $leaveRule)
                                                                    <tr>
                                                                    <th style="width: 30px;">
                                                                    <label>
                                                                        <input type="checkbox" id="selectAllCheckbox">
                                                                        <span>{{ $key + 1}}</span>
                                                                        </label>
                                                                        </th>
                                                                        <td>{{ $leaveRule->id }}</td>
                                                                        <td>{{ $leaveRule->grade->name }}</td>
                                                                        <td>{{ $leaveRule->duration }}</td>
                                                                        <td>{{ $leaveRule->uom }}</td>
                                                                        <td>{{ $leaveRule->start_date }}</td>
                                                                        <td>{{ $leaveRule->end_date }}</td>
                                                                        <td>{{ $leaveRule->islossofpay ? 'Yes' : 'No' }}</td>
                                                                        <td>{{ $leaveRule->employee_type }}</td>
                                                                        <td>{{ $leaveRule->status ? 'Active' : 'Inactive' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ========================YEAR END PROCESSING============================================= -->   
                                     <div class="mt-3">
                                            <h4>Year End Processing</h4>
                                            <div class="form-group">
                                                <label for="allow_carryover">Allow Carry Over:</label>
                                                <input type="checkbox" id="allow_carryover" name="allow_carryover" value="1" {{ $yearEndProcessing->allow_carryover ? 'checked' : '' }} disabled>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="carryover_limit">Carry Over Limit:</label>
                                                <input type="number" id="carryover_limit" name="carryover_limit" class="form-control" value="{{ $yearEndProcessing->carryover_limit }}" readonly>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="payat_yearend">Pay at Year-End:</label>
                                                <input type="checkbox" id="payat_yearend" name="payat_yearend" value="1" {{ $yearEndProcessing->payat_yearend ? 'checked' : '' }} disabled>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="carryover_limit">Min Balance:</label>
                                                <input type="number" id="min_balance" name="min_balance" class="form-control" value="{{ $yearEndProcessing->min_balance }}" readonly>
                                            </div>
                                            <div class="form-group mt-3 col-sm-6">
                                                <label for="carryover_limit">Max Balance:</label>
                                                <input type="number" id="max_balance" name="max_balance" class="form-control" value="{{ $yearEndProcessing->max_balance }}" readonly>
                                            </div>
 
                                            <div class="form-group">
                                                <label for="carryforward_toEL">Allow carryforward_toEL:</label>
                                                <input type="checkbox" id="carryforward_toEL" name="carryforward_toEL" value="1" {{ $yearEndProcessing->carryforward_toEL ? 'checked' : '' }} disabled>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="carryforward_toEL_limit">Carry Over Limit:</label>
                                                <input type="number" id="carryforward_toEL_limit" name="carryforward_toEL_limit" class="form-control" value="{{ $yearEndProcessing->carryforward_toEL_limit }}" readonly>
                                            </div>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('saveNow', ['leave_id' => $leavePolicy->leave_id]) }}" class="btn btn-primary">Save Now</button>
                                                <a href="{{ route('deleteLeaveData', ['leave_id' => $leavePolicy->leave_id]) }}" class="btn btn-secondary">Cancel</a>
                                            </div>
                                            </div>
                                            <!-- =================================END TABLE====================================== -->
                                        
                                        </div>
                                        <!-- ========================/YEAR END PROCESSING============================================= -->   
                                    </div>
                                </div>
                        </div> 
                    </div>
            <!-- =====================================================END SUMMARY======================================================= -->
                    </div>
                </div>
            </div>
        </div>
</div>
 <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

                
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#selectAllCheckbox').change(function() {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
});
</script>

<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>


@endsection



