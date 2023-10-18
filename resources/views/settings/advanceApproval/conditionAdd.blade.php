@extends('layout')

@section('content')
<div class="container">
        @if(session('success'))
                    <div id="success-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
            @endif
            <form method="POST" action="{{ route('advance-condition.store') }}">
    @csrf

    <div class="form-group">
        <label for="approval_rule_id">Approval Rule ID</label>
        <input type="hidden" name="approval_rule_id" value="{{ $approval_rule_id }}"> 
        @error('approval_rule_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label>Approval Type:</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="approval_type" id="hierarchy" value="Hierarchy">
            <label class="form-check-label" for="hierarchy">Hierarchy</label>
        </div>
        <!-- Hierarchy ID and Max Level Fields -->
        <div class="form-group" id="hierarchyFields">
            <label for="hierarchy_id">Hierarchy ID (optional)</label>
            <select name="hierarchy_id" id="hierarchy_id" class="form-control" disabled>
                <option disabled selected>Select Hiearchy</option>
                @foreach($hierarchies as $hierachy)
                <option value="{{ $hierachy->id }}">{{ $hierachy->name }}</option>
                @endforeach
            </select>
            @error('hierarchy_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group" id="maxLevelFields">
            <label for="MaxLevel">Select Level</label>
            <select name="MaxLevel" id="MaxLevel" class="form-control" disabled>
                <!-- Options will be populated dynamically based on the selected hierarchy -->
            </select>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="approval_type" id="single_user" value="Single User">
            <label class="form-check-label" for="single_user">Single User</label>
        </div>
        <!-- Single User and Auto Approval Fields -->
        <div class="form-group" id="employeeFields">
            <label for="employee_id">Employee ID (optional)</label>
            <select name="employee_id" id="employee_id" class="form-control" disabled>
                <option disabled selected>Select Hiearchy</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}({{ $user->employee_id }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="approval_type" id="auto_approval" value="Auto Approval">
            <label class="form-check-label" for="auto_approval">Auto Approval</label>
        </div>
    </div>  

    <div class="form-group" id="autoApprovalFields">
        <label for="AutoApproval">Auto Approval (optional)</label>
        <input type="checkbox" name="AutoApproval" id="AutoApproval" class="form-control" disabled>
    </div>

    <button type="submit" class="btn btn-primary mt-4">Submit</button>
</form>



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Listen for changes in the hierarchy select field
    document.getElementById('hierarchy_id').addEventListener('change', function () {
        // Get the selected hierarchy ID
        const hierarchyId = this.value;

        // Send an AJAX request to fetch levels associated with the selected hierarchy
        fetch(`/levels/${hierarchyId}`)
            .then(response => response.json())
            .then(levels => {
                const levelSelect = document.getElementById('MaxLevel');
                levelSelect.innerHTML = ''; // Clear existing options

                // Add options for each level
                levels.forEach(level => {
                    const option = document.createElement('option');
                    option.value = 'Level'+level.level;
                    option.textContent = 'Level'+level.level;
                    levelSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>

<script>
    const radioButtons = document.querySelectorAll('input[name="approval_type"]');
    const hierarchyFields = document.getElementById('hierarchyFields');
    const maxLevelFields = document.getElementById('maxLevelFields');
    const employeeFields = document.getElementById('employeeFields');
    const autoApprovalFields = document.getElementById('autoApprovalFields');

    radioButtons.forEach((radio) => {
        radio.addEventListener('change', () => {
            // Disable all related fields
            hierarchyFields.querySelector('select').disabled = true;
            maxLevelFields.querySelector('select').disabled = true;
            employeeFields.querySelector('select').disabled = true;
            autoApprovalFields.querySelector('input').disabled = true;

            // Enable fields related to the selected radio button
            if (radio.id === 'hierarchy') {
                hierarchyFields.querySelector('select').disabled = false;
                maxLevelFields.querySelector('select').disabled = false;
            } else if (radio.id === 'single_user') {
                employeeFields.querySelector('select').disabled = false;
            } else if (radio.id === 'auto_approval') {
                autoApprovalFields.querySelector('input').disabled = false;
            }
        });
    });
</script>

@endsection
