
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

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">      
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Approval Rules</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Setting Management/Approval </li>
                    </ul>
                </div>
                @if(session('success'))
                    <div id="success-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row mt-4">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                        <form method="POST" action="{{ route('condition.store')}}">
                            @csrf
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Add Conditions</h3>
                                    </div>
                                    <div class="modal-body">
                                            <div class="form-group">
                                                <input type="hidden" name="approval_rule_id" value="{{ $approval_rule_id }}"> 
                                                @error('approval_rule_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="container">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approval_type" id="hierarchy" value="Hierarchy">
                                                    <label class="form-check-label" for="radio1">
                                                        Hierarchy
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group" id="hierarchyFields">
                                                    <label class="col-form-label">Hierarchy ID (optional)<span class="text-danger">*</span></label>
                                                    <select name="hierarchy_id" id="hierarchy_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                    <option disabled selected>Select Hiearchy</option>
                                                    @foreach($hierarchies as $hierarchy)
                                                    <option value="{{ $hierarchy->id }}">{{ $hierarchy->name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>    
                                            <div class="col-sm-6">
                                                <div class="form-group" id="maxLevelFields">
                                                <label class="col-form-label">Select Level<span class="text-danger">*</span></label>
                                                <select name="MaxLevel" id="MaxLevel" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                <!-- Options will be populated dynamically based on the selected hierarchy -->
                                                </select>
                                                </div>
                                            </div> 
                                            <div class="container mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approval_type" id="single_user" value="Single User">
                                                    <label class="form-check-label" for="single_user">
                                                        Single User
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group" id="employeeFields">
                                                    <label class="col-form-label">Employee ID (Optional)<span class="text-danger">*</span></label>
                                                    <select  name="employee_id" id="employee_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                    <option disabled selected>Select Employee</option>
                                                    @foreach($users as $user)
                                                    <option value="{{ $user->id}}">{{ $user->name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="container mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approval_type" id="auto_approval" value="Auto Approval">
                                                    <label class="form-check-label" for="auto_approval">
                                                        Auto Approval
                                                    </label>
                                                </div>
                                            </div> 
                                            <div class="col-sm-6">
                                                <div class="form-group" id="autoApprovalFields">
                                                    <label class="col-form-label">Auto Approval (Optional)<span class="text-danger">*</span></label>
                                                    <input type="checkbox" name="AutoApproval" id="AutoApproval" class="form-control" disabled>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="modal-footer justify-content-end mt-3">
                                            <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                            &nbsp;  &nbsp;   &nbsp;
                                            <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Add Condition -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div><!-- /Page Content --> 
</div> 
<!-- /Page Wrapper -->
              
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
@endsection



