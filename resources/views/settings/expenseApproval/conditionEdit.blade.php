@extends('layout') 

@section('content')

<div class="container">
    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Edit Condition</h1>
    <form method="POST" action="{{ route('expense-condition.update', $approval_condition->id) }}">
        @csrf
        @method('patch') 
        <div class="form-group">
            <label>Approval Type:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="approval_type" id="hierarchy" value="Hierarchy" {{ $approval_condition->approval_type === 'Hierarchy' ? 'checked' : '' }}>
                <label class="form-check-label" for="hierarchy">Hierarchy</label>
            </div>
            <!-- Hierarchy ID and Max Level Fields -->
            <div class="form-group" id="hierarchyFields">
                <label for="hierarchy_id">Hierarchy ID (optional)</label>
                <select name="hierarchy_id" id="hierarchy_id" class="form-control" {{ $approval_condition->approval_type !== 'Hierarchy' ? 'disabled' : '' }}>
                    <option disabled selected>Select Hierarchy</option>
                    @foreach($hierarchies as $hierarchy)
                        <option value="{{ $hierarchy->id }}" {{ $approval_condition->hierarchy_id == $hierarchy->id ? 'selected' : '' }}>{{ $hierarchy->name }}</option>
                    @endforeach
                </select>
                @error('hierarchy_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" id="maxLevelFields">
                <label for="MaxLevel">Select Level</label>
                <select name="MaxLevel" id="MaxLevel" class="form-control" {{ $approval_condition->approval_type !== 'Hierarchy' ? 'disabled' : '' }}>
                    <!-- Options will be populated dynamically based on the selected hierarchy -->
                </select>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="approval_type" id="single_user" value="Single User" {{ $approval_condition->approval_type === 'Single User' ? 'checked' : '' }}>
                <label class="form-check-label" for="single_user">Single User</label>
            </div>
            <!-- Single User and Auto Approval Fields -->
            <div class="form-group" id="employeeFields">
                <label for="employee_id">Employee ID (optional)</label>
                <select name="employee_id" id="employee_id" class="form-control" {{ $approval_condition->approval_type !== 'Single User' ? 'disabled' : '' }}>
                    <option disabled selected>Select Employee</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $approval_condition->employee_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->employee_id }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="approval_type" id="auto_approval" value="Auto Approval" {{ $approval_condition->approval_type === 'Auto Approval' ? 'checked' : '' }}>
                <label class="form-check-label" for="auto_approval">Auto Approval</label>
            </div>
        </div>  

        <div class="form-group" id="autoApprovalFields">
        <label for="AutoApproval">Auto Approval (optional)</label>
        <input type="checkbox" name="AutoApproval" id="AutoApproval" class="form-control" disabled>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>

    <script>
        // Add JavaScript logic for enabling/disabling fields based on radio button selection (similar to the create form)
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
</div>



</div>
@endsection
