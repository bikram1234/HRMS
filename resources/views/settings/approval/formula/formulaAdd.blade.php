@extends('layout') 

@section('content')

<div class="container">
        @if(session('success'))
                    <div id="success-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
            @endif
            <h1>Add New addition Formula</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Condition</th>
                <th>Field</th>
                <th>Operator</th>
                <th>Value</th>
                <th>Action</th>
        </tr>
        </thead>
        <tbody>
                @foreach ($formulas as $formula)
                    <tr>

                            <td>{{ $formula->condition }}</td>
                            <td>{{ $formula->field }}</td>
                            <td>{{ $formula->operator }}</td>
                            @if ($formula->value)
                            <td>{{ $formula->value }}</td>
                            @else
                            <td>{{ $formula->employee->name }}</td>
                            @endif
                        <td>    
                        <form action="{{ route('formula.delete', $formula->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Formula?')">Delete</button>
                            </form>
                        </td> <!-- Action column, you can add actions here -->
                    </tr>
                @endforeach

                    </tbody>
            </table>

    <form id="formula-form" method="POST" action="{{ route('formula.store') }}">
        @csrf

        <!-- Condition -->
        <div class="form-group">
            <label for="condition">Condition:</label>
            <select id="condition" name="condition">
                <option value>Select</option>
                <option value="AND">AND</option>
                <option value="OR">OR</option>
                <option value="NOT">NOT</option>
            </select>
        </div>

        <!-- Field -->
        <div class="form-group mt-3">
            <label for="field">Field:</label>
            <select id="field" name="field" required>
                <option value="User">User</option>
                <option value="No. of Days">No. of Days</option>
                <!-- Add other field options as needed -->
            </select>
            @error('field')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Operator -->
        <div class="form-group mt-3">
            <label for="operator">Operator:</label>
            <select id="operator" name="operator" required>
                <option value="Is">Is</option>
                <option value="Is Not">Is Not</option>
                <option value="Is Greater Than">Is Greater Than</option>
                <option value="Is Less Than">Is Less Than</option>
                <option value="Is Less Than or Equal To">Is Less Than or Equal To</option>
                <option value="Is Greater Than or Equal To">Is Greater Than or Equal To</option>
                <!-- Add other operator options as needed -->
            </select>
 
        <!-- Value -->
        <div class="form-group mt-3" id="value-group">
            <label for="value">Value:</label>
            <input type="text" id="value" name="value">
            <select id="user-id" name="employee_id" style="display: none;">
                <option value="">Select user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <input type="hidden" id="selected-user-id" name="selected_employee_id">
            @error('value')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
            @error('employee_id')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        <!-- Condition ID (if needed) -->
        <div class="form-group mt-3">
            <input type="hidden" id="condition-id" name="condition_id" value="{{ $approvalConditionId }}" >
        </div>

        <button type="submit" class="btn btn-primary">Add Formula</button>
    </form>

<script>
    $(document).ready(function () {
        // Get references to the relevant form elements
        var fieldSelect = $('#field');
        var valueInput = $('#value');
        var userIdSelect = $('#user-id');
        var selecteduserIdInput = $('#selected-user-id');

        // Function to show/hide the user dropdown based on the selected field
        function toggleuserDropdown() {
            var selectedField = fieldSelect.val();
            if (selectedField === 'User') {
                userIdSelect.show();
                valueInput.hide();
                selecteduserIdInput.prop('disabled', false);
            } else {
                userIdSelect.hide();
                valueInput.show();
                selecteduserIdInput.prop('disabled', true).val('');
            }
        }

        // Initially call the function to set the initial state
        toggleuserDropdown();

        // Add change event listener to the field select
        fieldSelect.change(function () {
            toggleuserDropdown();
        });
    });
</script>


</div>
@endsection
