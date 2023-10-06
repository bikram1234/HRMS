

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


.word {
 margin-left: 10px; 
 }
                            

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
<!-- Page Content -->
<div class="content container-fluid">
<!-- row -->
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Leave Policy</h5>
                            </div>
                <div class="modal-body">
                    <div class="card tab-box">
						<div class="row user-tabs">
							<div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
								<ul class="nav nav-tabs nav-tabs-bottom">
									<li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Leave Policy</a></li>
									<li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link active">Leave Plan</a></li>
									<li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Year End Processing</a></li>
                                    <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Summary</a></li>
								</ul>
							</div>
						</div> 
                    </div>
            <form method="POST" action="{{ route('leaveplan.store') }}">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="leave_id" name="leave_id" value="{{ $leave_id }}">
                                @error('leave_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        @error('leave_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="form-group">
                            <label for="attachment_required">Attachment Required:</label>
                                <input type="checkbox" id="attachment_required" name="attachment_required" value="1">
                                    @error('attachment_required')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Gender</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="gender" name="gender">
                                            <option value="F">Female</option>
                                            <option value="M">Male</option>
                                            <option value="A">All</option>
                                        </select>
                                    @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Leave Year</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="leave_year" id="leave_year">
                                            <option value="Financial Year">Financial Year</option>
                                            <option value="Calender Year">Calender Year</option>
                                        </select>
                                    @error('leave_year')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Credit Frequency</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="credit_frequency" name="credit_frequency">
                                            <option value="Monthly">Monthly</option>
                                            <option value="Yearly">Yearly</option>
                                        </select>
                                    @error('credit_frequency')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Credit </label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="credit" id="credit">
                                                <option value="Start Of Period">Start Of Period</option>
                                                <option value="End of Period">End Of Period</option>
                                        </select>
                                        @error('credit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <h4 class="mt-3">Leave Limits</h4>
                                <label class="mt-3">
                                    <input type="checkbox" id="leave_limits_include_public_holidays" name="include_public_holidays">
                                    <span>Include Public Holidays</span>
                                    @error('include_public_holidays')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="include_weekends" name="include_weekends">
                                    <span>Include Weekends</span>
                                    @error('include_weekends')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="can_be_clubbed_with_el" name="can_be_clubbed_with_el">
                                    <span>Can be clubbed with EL</span>
                                    @error('can_be_clubbed_with_el')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="can_be_clubbed_with_cl" name="can_be_clubbed_with_cl">
                                    <span>Can be clubbed with CL</span>
                                    @error('can_be_clubbed_with_cl')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="can_be_half_day" name="can_be_half_day">
                                    <span>Can be half day</span>
                                    @error('can_be_half_day')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <h4 class="mt-3">Can Avail in</h4>
                                <label class="mt-3">
                                    <input type="checkbox" id="probation_period" name="probation_period">
                                    <span>Probation Period</span>
                                    @error('probation_period')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="regular_period" name="regular_period">
                                    <span>Regular Period</span>
                                    @error('regular_period')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="contract_period" name="contract_period">
                                    <span>Contract Period</span>
                                    @error('contract_period')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                </label>
                                <label class="mt-3">
                                    <input type="checkbox" id="notice_period" name="notice_period">
                                    <span>Notice Period</span>
                                    @error('notice_period')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </label>
                                <div class="col-auto float-right ml-auto p-4">
                                    <a href="#"  class="btn add-btn" data-toggle="modal" data-target="#myModal{{ $leave_id }}"><i class="fa fa-plus"></i>Create Rule</a>
                                    
                                    <button type="submit" class="btn btn-primary">Add Leave Plan</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                </div>
                             </form>
        
                                <!-- Add Leave Rule -->
                                        <div id="myModal{{ $leave_id }}" class="modal custom-modal fade" role="dialog"> 
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title">Add Leave Rule</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                            <div class="container">
                                                <form method="POST" action="{{ route('leaverule.store') }}">
                                                    @csrf

                                                    <div class="form-group">
                                                            <input type="hidden" id="leave_id" name="leave_id" value="{{ $leave_id }}">
                                                            @error('leave_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="grade_id">Grade:</label>
                                                        <select id="grade_id" name="grade_id" class="form-control" required>
                                                            <!-- Populate options dynamically from your database or use a loop -->
                                                            <option disabled selected>Select</option>
                                                            @foreach ($grades as $grade)
                                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                            @endforeach
                                                            <!-- Add more options as needed -->
                                                        </select>
                                                        @error('grade_id')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror  
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="duration">Duration:</label>
                                                        <input type="number" id="duration" name="duration" class="form-control" required>
                                                        @error('duration')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror  
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="uom">Unit of Measure:</label>
                                                        <select class="form-control" id="uom" name="uom">
                                                            <option disabled selected>Select:</option>
                                                            <option value="Day">Day</option>
                                                            <option value="Month">Month</option>
                                                            <option value="Year">Year</option>
                                                        </select>
                                                        @error('uom')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror  
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="start_date">Start Date:</label>
                                                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                                                        @error('start_date')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror  
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="end_date">End Date:</label>
                                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                                        @error('end_date')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror  
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="islossofpay">Loss of Pay:</label>
                                                        <select class="form-control" id="status" name="islossofpay">
                                                        <option disabled selected>Select:</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    @error('islossofpay')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="employee_type">Employee Type:</label>
                                                        <select class="form-control" id="status" name="employee_type">
                                                            <option disabled selected>Select:</option>
                                                            <option value="P">Probation Period</option>
                                                            <option value="R">Regular Period</option>
                                                            <option value="C">Contract Period</option>
                                                            <option value="N">Notice Period</option>
                                                            <option value="A">All</option>
                                                        </select>
                                                        @error('employee_type')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror  
                                                    </div>

                                                    <div class="form-group md-3">
                                                        <label for="status">Status:</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option disabled selected>Choose status:</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                        @error('status')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror   
                                                    </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer justify-content-end mt-3">
                                                        <button type="submit" class="btn btn-primary">Add Rule</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                </form>
                                            </div>

                                                </div>
                                            </div>
                                        </div>
                                <!-- /End  Leave Rule -->

                                <h2>Leave Rules</h2>
                                <!-- Table -->
                                <div class="row">
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
                                                                <th>Employement Type</th>
                                                                <th>Status</th>
                                                            
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($leaveRules as $key => $leaveRule)
                                                            <tr>
                                                            <th style="width: 30px;">
                                                            <label>
                                                                <input type="checkbox" id="selectAllCheckbox">
                                                                <span>{{ $key + 1 }}</span>
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
                                    </div>
                                </div> 
                                <!-- End Table -->
                                <!-- Button -->
                                <div class="modal-footer justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Previous</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="submit" class="btn btn-primary" onclick="redirectToYearEndProcessing('{{ route('yearendprocessing.create', ['leave_id' => $leave_id]) }}')">Save & Continue</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                </div> 
                                <!--/End Button -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>       
        </div>
     <!-- /row -->


     <!-- Year End Processing -->


     <!--/ End Year End Processing -->
</div>
<!-- Page Content -->
</div>
<!-- /Page Wrapper -->

                
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
    function redirectToYearEndProcessing(url) {
        window.location.href = url;
    }
</script>
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
<script>
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>







@endsection



