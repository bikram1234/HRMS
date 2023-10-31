@extends('layout')
@section('content')

        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="{{ route('approval.store') }}">
        @csrf

        <div class="form-group">
            <label for="for">For:</label>
            <select name="For" id="For" class="form-control">
                <option disabled selected>Select Level</option>
                <option value="Leave">Leave</option>
                <option value="Expense">Expense</option>
                <option value="Loan">Loan</option>
            </select>
            @error('For')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="RuleName">Rule Name:</label>
            <input type="text" name="RuleName" id="RuleName"  class="form-control">
            @error('RuleName')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="Type">Type</label>
            <select id="Type" name="type_id" class="form-control">
                <!-- Options will be dynamically populated here -->
            </select>
            @error('type_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
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

<script>
        document.addEventListener('DOMContentLoaded', function () {
        var forSelect = document.getElementById('For');
        var typeSelect = document.getElementById('Type');
        
        // ...

        // Function to populate the "Type" dropdown based on the selected "For" value
        function populateTypeDropdown(selectedFor) {
            typeSelect.innerHTML = ''; // Clear existing options
            
            if (selectedFor === '') {
                // If "Choose For:" is selected, display the default "Select For First" option
                var defaultOption = document.createElement('option');
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.textContent = 'Select For First';
                typeSelect.appendChild(defaultOption);
            } else {
                // Define and populate options based on the selected "For" value
                var options;
                if (selectedFor === 'Leave') {
                    options = {!! json_encode($leavetypes->pluck('name', 'id')) !!};
                } else {
                    options = []; // Default empty options
                }
                
                // Populate the "Type" dropdown with options
                for (var id in options) {
                    if (options.hasOwnProperty(id)) {
                        var optionElement = document.createElement('option');
                        optionElement.value = id; // Set the value to the ID
                        optionElement.textContent = options[id]; // Set the text content to the name
                        typeSelect.appendChild(optionElement);
                    }
                }
            }
        }

        // Initially populate the "Type" dropdown when the page loads
        populateTypeDropdown(forSelect.value);

        // ...

        forSelect.addEventListener('change', function () {
            var selectedFor = forSelect.value;
            populateTypeDropdown(selectedFor);
        });
    });

</script>   


</div>



@endsection