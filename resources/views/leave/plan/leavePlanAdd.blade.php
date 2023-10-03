@extends('layout')


@section('content')

        
@if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="{{ route('leaveplan.store') }}">
        @csrf

        <div class="form-group">
                    <input type="hidden" id="leave_id" name="leave_id" value="{{ $leave_id }}">
                    @error('leave_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

        <div class="form-group">
                    <label for="attachment_required">Attachment Required:</label>
                    <input type="checkbox" id="attachment_required" name="attachment_required" value="1">
                    @error('attachment_required')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" class="form-control">
                    <option disabled selected>Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="A">All</option>
                </select>
                @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="leave_year">Leave Year:</label>
                <select name="leave_year" id="leave_year" class="form-control">
                    <option disabled selected>Select</option>
                    <option value="Financial Year">Financial Year</option>
                    <option value="Calender Year">Calender Year</option>
                </select>
                @error('leave_year')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                    <label for="credit_frequency">credit_frequency :</label>
                    <select name="credit_frequency" id="credit_frequency" class="form-control">
                        <option disabled selected>Select:</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                    @error('credit_frequency')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            <div class="form-group">
                <label for="credit">Credit:</label>
                <select name="credit" id="credit" class="form-control">
                    <option disabled selected>Select:</option>
                    <option value="Start Of Period">Start Of Period</option>
                    <option value="End of Period">End Of Period</option>
                </select>
                @error('credit')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="leave_limits_include_public_holidays">Include Public Holidays:</label>
                <input type="checkbox" id="leave_limits_include_public_holidays" name="include_public_holidays">
                @error('include_public_holidays')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label for="include_weekends">Include Weekends:</label>
                <input type="checkbox" id="include_weekends" name="include_weekends">
                @error('include_weekends')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label for="can_be_clubbed_with_el">Can be Clubbed With EL:</label>
                <input type="checkbox" id="can_be_clubbed_with_el" name="can_be_clubbed_with_el">
                @error('can_be_clubbed_with_el')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <label for="can_be_clubbed_with_cl">Can be Clubbed With CL:</label>
                <input type="checkbox" id="can_be_clubbed_with_cl" name="can_be_clubbed_with_cl">
                @error('can_be_clubbed_with_cl')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="can_be_half_day">Can be half day:</label>
                <input type="checkbox" id="can_be_half_day" name="can_be_half_day">
                @error('can_be_half_day')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div>
                Can Avail In
            </div>
            <div class="form-group">
                <label for="probation_period"> Probation Period:</label>
                <input type="checkbox" id="probation_period" name="probation_period">
                @error('probation_period')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label for="regular_period">Regular Period:</label>
                <input type="checkbox" id="regular_period" name="regular_period">
                @error('regular_period')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label for="contract_period">Contract Period:</label>
                <input type="checkbox" id="contract_period" name="contract_period">
                @error('contract_period')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label for="notice_period">Notice Period:</label>
                <input type="checkbox" id="notice_period" name="notice_period">
                @error('notice_period')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
<!-- Button to trigger the modal -->
<button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal{{ $leave_id }}">
        Add Rule
    </button>

        <button type="submit" class="btn btn-primary mt-4">Add Leave Plan</button>
    </form>



    <!-- The Modal -->
    <div class="modal" id="myModal{{ $leave_id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Rule</button>
                    </div>
            </form>
        </div>

            </div>
        </div>
    </div>

    <h1>Leave Rules</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Grade</th>
                <th>Duration</th>
                <th>UOM</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Loss of Pay</th>
                <th>Employee Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveRules as $leaveRule)
                <tr>
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

@endsection