@extends('layout')
@section('content')

        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="{{ route('hierarchy.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" >
            @error('name')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

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
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
</div>

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

@endsection