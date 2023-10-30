@extends('layout')
@section('content')

<div class="container mt-5">
        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <table class="table">
            <thead>
                <tr>
                    <th>Hierarchy Name</th>
                    <th>Level</th>
                    <th>Value</th>
                    <th>Employee</th>
                    <th>start_date</th>
                    <th>End_Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($levels->count() > 0)
                @foreach($levels as $level)
                    <tr>
                        <td>{{ $hierarchy->name }}</td>
                        <td>{{ $level->level }}</td>
                        <td>{{ $level->value }}</td>
                        @if ($level->employee_id)
                        <td>{{ $level->employeeName->name }}</td>
                        @else
                        <td>No Employee Assigned</td>
                    @endif
                        <td>{{ $level->start_date }}</td>
                        <td>{{ $level->end_date }}</td>
                         @if($level->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                     
                    </tr>
                @endforeach
                @else
                <h1>No datas</h1>
                @endif
            </tbody>
    </table>

    <form method="POST" action="{{ route('level.store', ['hierarchyId' => $hierarchy->id]) }}">
        @csrf

        <div class="form-group">
            <label for="level">Level</label>
            <select name="level" id="level" class="form-control">
                <option disabled selected>Select Level</option>
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
            </select>
            @error('level')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="value">Value</label>
            <select name="value" id="value" class="form-control">
                <option disabled selected>Select</option>
                <option value="IS">Immediate Supervisor</option>
                <option value="SH">Section Head</option>
                <option value="DH">Department Head</option>
                <option value="MM">Management</option>
                <option value="HR">Human Resource</option>
                <option value="FH">Finance Head</option>
            </select>
            @error('value')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div id="userField" style="display: none;">
            <div class="form-group">
                <label for="employee_id">Select User</label>
                <select name="employee_id" id="employee_id" class="form-control">
                    <!-- You can populate this dropdown with users from your database -->
                    @foreach ($users as $user)
                        <option value="{{ $user->employee_id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('employee_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>


        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" >
            @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" >
            @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
            <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
        // Get references to the level and user field
        var $levelField = $('#level');
        var $userField = $('#userField');
        var $employeeIdField = $('#employee_id');

        // Initial visibility state of user field
        $userField.hide();

        // Event handler for level selection change
        $levelField.on('change', function () {
            // Get the selected level value
            var selectedLevel = $(this).val();

            // Check if the selected level is 3
            if (selectedLevel === '3') {
                $userField.show(); // Show user field
            } else {
                $userField.hide(); // Hide user field
                $employeeIdField.val(''); // Clear the employee_id field
            }
        });

        // Handle form submission
        $('form').on('submit', function () {
            // If the userField is hidden, remove the employee_id field from the form data
            if ($userField.is(':hidden')) {
                $employeeIdField.removeAttr('name');
            }
        });
    });

</script>
</div>

@endsection