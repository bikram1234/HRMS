@extends('layout')
@section('content')

        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="" id="approvalForm">
        @csrf

        <div class="form-group">
            <label for="for">For:</label>
            <select name="For" id="For" class="form-control">
                <option disabled selected>Select Level</option>
                <option value="Leave">Leave</option>
                <option value="Expense">Expense</option>
                <option value="Loan">Loan</option>
                <option value="Leave Encashment">Leave Encashment</option>
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

        function populateTypeDropdown(selectedFor) {
            typeSelect.innerHTML = ''; // Clear existing options

            if (selectedFor === '') {
                // If "Choose For:" is selected, display the default "Select For First" option
                var defaultOption = document.createElement('option');
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.textContent = 'Select For First';
                typeSelect.appendChild(defaultOption);
            } else if (selectedFor === 'Leave') {
                // Define and populate options based on the selected "For" value 'Leave'
                var options = {!! json_encode($leavetypes->pluck('name', 'id')) !!};

                // Populate the "Type" dropdown with options
                for (var id in options) {
                    if (options.hasOwnProperty(id)) {
                        var optionElement = document.createElement('option');
                        optionElement.value = id; // Set the value to the ID
                        optionElement.textContent = options[id]; // Set the text content to the name
                        typeSelect.appendChild(optionElement);
                    }
                }
            } else if (selectedFor === 'Leave Encashment') {
                // Define and populate options for 'Leave Encashment'
                var encashments = {!! json_encode($encashments->pluck('name', 'id')) !!};

                for (var id in encashments) {
                    if (encashments.hasOwnProperty(id)) {
                        var optionElement = document.createElement('option');
                        optionElement.value = id; // Set the value for Leave Encashment
                        optionElement.textContent = encashments[id]; // Set the text content
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var forSelect = document.getElementById('For');
        var approvalForm = document.getElementById('approvalForm');

        forSelect.addEventListener('change', function () {
            var selectedFor = forSelect.value;
            var formAction = '';  // Initialize form action

            if (selectedFor === 'Leave') {
                formAction = "{{ route('approval.leave.store') }}";
            } else if (selectedFor === 'Expense') {
            
            } else if (selectedFor === 'Loan') {
                
            } else if (selectedFor === 'Leave Encashment') {
                formAction = "{{ route('approval.encashment.store') }}";
            }

            approvalForm.setAttribute('action', formAction);
        });
    });
</script>


</div>



@endsection