@extends('layout')

@section('content')

<div class="container mt-5">
    <h1>Summary for Leave ID: </h1>

    <h2>Leave Policy:</h2>
    <div class="form-group">
        <label for="policy_name">Policy Name:</label>
        <input type="text" class="form-control" id="policy_name" name="policy_name" value="{{ $leavePolicy->policy_name }}" readonly>
    </div>
    <div class="form-group">
        <label for="policy_description">Policy Description:</label>
        <textarea class="form-control" id="policy_description" name="policy_description" readonly>{{ $leavePolicy->policy_description }}</textarea>
    </div>
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $leavePolicy->start_date }}" readonly>
    </div>
    <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $leavePolicy->end_date }}" readonly>
    </div>
    <!-- Add more leave policy fields here -->

    <h2>Leave Plan:</h2>
    <div class="form-group">
        <label for="attachment_required">Attachment Required:</label>
        <input type="checkbox" id="attachment_required" name="attachment_required" value="1" {{ $leavePlan->attachment_required ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">Include Public holidays:</label>
        <input type="checkbox" id="attachment_required" name="include_public_holidays" value="1" {{ $leavePlan->include_public_holidays ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">include_weekends:</label>
        <input type="checkbox" id="attachment_required" name="include_weekends" value="1" {{ $leavePlan->include_weekends    ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">Can be Clubbed with el:</label>
        <input type="checkbox" id="can_be_clubbed_with_el" name="can_be_clubbed_with_el" value="1" {{ $leavePlan->can_be_clubbed_with_el    ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">Can be Clubbed with cl:</label>
        <input type="checkbox" id="can_be_clubbed_with_cl" name="can_be_clubbed_with_cl" value="1" {{ $leavePlan->can_be_clubbed_with_cl    ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">Can be Half Day:</label>
        <input type="checkbox" id="can_be_half_day" name="can_be_half_day" value="1" {{ $leavePlan->can_be_half_day    ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">Probation Period:</label>
        <input type="checkbox" id="probation_period" name="probation_period" value="1" {{ $leavePlan->probation_period    ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="attachment_required">Regular Period:</label>
        <input type="checkbox" id="regular_period" name="regular_period" value="1" {{ $leavePlan->regular_period    ? 'checked' : '' }} disabled>
    </div>    
    <div class="form-group">
        <label for="attachment_required">Notice Period:</label>
        <input type="checkbox" id="notice_period" name="notice_period" value="1" {{ $leavePlan->notice_period    ? 'checked' : '' }} disabled>
    </div>  
    <div class="form-group">
        <label for="attachment_required">Probation Period:</label>
        <input type="checkbox" id="probation_period" name="probation_period" value="1" {{ $leavePlan->probation_period    ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="gender">Gender:</label>
        <select name="gender" id="gender" class="form-control" disabled>
            <option value="M" {{ $leavePlan->gender === 'M' ? 'selected' : '' }}>Male</option>
            <option value="F" {{ $leavePlan->gender === 'F' ? 'selected' : '' }}>Female</option>
            <option value="A" {{ $leavePlan->gender === 'A' ? 'selected' : '' }}>All</option>
        </select>
    </div>
    <!-- Add more leave plan fields here -->

    <h2>Leave Rule:</h2>
    <!-- Add leave rule fields here (similar to leave policy and leave plan) -->
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
    <h2>Year-End Processing:</h2>
    <div class="form-group">
        <label for="allow_carryover">Allow Carry Over:</label>
        <input type="checkbox" id="allow_carryover" name="allow_carryover" value="1" {{ $yearEndProcessing->allow_carryover ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="carryover_limit">Carry Over Limit:</label>
        <input type="number" id="carryover_limit" name="carryover_limit" class="form-control" value="{{ $yearEndProcessing->carryover_limit }}" readonly>
    </div>
    <div class="form-group">
        <label for="payat_yearend">Pay at Year-End:</label>
        <input type="checkbox" id="payat_yearend" name="payat_yearend" value="1" {{ $yearEndProcessing->payat_yearend ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="carryover_limit">Min Balance:</label>
        <input type="number" id="min_balance" name="min_balance" class="form-control" value="{{ $yearEndProcessing->min_balance }}" readonly>
    </div>
    <div class="form-group">
        <label for="carryover_limit">Max Balance:</label>
        <input type="number" id="max_balance" name="max_balance" class="form-control" value="{{ $yearEndProcessing->max_balance }}" readonly>
    </div>
    <!-- Add more year-end processing fields here -->
    <div class="form-group">
        <label for="carryforward_toEL">Allow carryforward_toEL:</label>
        <input type="checkbox" id="carryforward_toEL" name="carryforward_toEL" value="1" {{ $yearEndProcessing->carryforward_toEL ? 'checked' : '' }} disabled>
    </div>
    <div class="form-group">
        <label for="carryforward_toEL_limit">Carry Over Limit:</label>
        <input type="number" id="carryforward_toEL_limit" name="carryforward_toEL_limit" class="form-control" value="{{ $yearEndProcessing->carryforward_toEL_limit }}" readonly>
    </div>
    <!-- Add more sections for other data as needed -->

    <div class="mt-4">
        <a href="{{ route('saveNow', ['leave_id' => $leavePolicy->leave_id]) }}" class="btn btn-primary">Save Now</button>
        <a href="{{ route('deleteLeaveData', ['leave_id' => $leavePolicy->leave_id]) }}" class="btn btn-danger">Cancel</a>
    </div>
</div>

@endsection
