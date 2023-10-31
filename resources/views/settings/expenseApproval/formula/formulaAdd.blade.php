
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
                    <form method="POST" action="{{ route('formula.store')}}">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Formula</h4>  
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Condition -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Condition:<span class="text-danger">*</span></label>
                                                <select id="condition" name="condition" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                <option disabled selected>Select Condition</option>
                                                <option value="AND">AND</option>
                                                <option value="OR">OR</option>
                                                <option value="NOT">NOT</option>
                                                </select>
                                                @error('condition')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Field -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Field:<span class="text-danger">*</span></label>
                                                <select id="field" name="field" class="form-select  form-select-md" aria-label="Default select example" style="height:45px" required>
                                                <option value="">Select Field</option>
                                                <option value="User">User</option>
                                                <option value="No.of Days">No.of Days</option>
                                                </select>
                                                @error('field')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                            
                                        <!-- Operator -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label class="col-form-label form-select-md">Operator:</label>
                                                <select id="operator" name="operator" class="form-select" aria-label="Default select example" style="height:45px" required>
                                                    <option value="">Select Operator</option>
                                                    <option value="Is">Is</option>
                                                    <option value="Is Not">Is Not</option>
                                                    <option value="Is Greater Than">Is Greater Than</option>
                                                    <option value="Is Less Than">Is Less Than</option>
                                                    <option value="Is Less Than or Equal To">Is Less Than or Equal To</option>
                                                    <option value="Is Greater Than or Equal To">Is Greater Than or Equal To</option>
                                                </select>
                                                @error('operator')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                </div>
                                            </div>

                                            <!-- Value -->
                                            <div class="col-sm-6">
                                                <div class="form-group" id="value-group">
                                                    <label class="col-form-label form-select-md">Value:</label>
                                                    <input type="text" id="value" name="value" class="form-control">
                                                    <select id="user-id" name="employee_id"  class="form-select" aria-label="Default select example" style="height:45px"  style="display: none;">
                                                    <option value="">Select user</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" id="selected-user-id" name="selected_employee_id" class="form-control">
                                                    @error('value')
                                                            <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @error('employee_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                        <!-- Condition ID (if needed) -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" id="condition-id" name="condition_id"  value="{{ $approvalConditionId }}"  class="form-control" >
                                            </div>
                                        </div>
                                       
                                    </div>  
                                        <div class="modal-footer justify-content-start mt-3">
                                            <button type="submit" name="save" class="btn btn-primary">Add Formula</button>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>       
         <!-- Table -->
         <div class="row mt-4">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="container table-responsive">  
                                <table id="example" class="table table-striped custom-table" style="width: 100%">
                                    <thead>
                                    <tr>
                                    <th style="width: 30px;">
                                        <label>
                                            <input type="checkbox" id="selectAllCheckbox">
                                            <span>SI</span>
                                        </label>
                                    </th>
                                    <th>Condition</th>
                                    <th>Field</th>
                                    <th>Operator</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formulas as $key => $formula)
                                <tr>
                                <th style="width: 30px;">
                                    <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        <span>{{ $key + 1 }}</span>
                                    </label>
                                </th>
                                <td>{{ $formula->condition }}</td>
                                <td>{{ $formula->field }}</td>
                                <td>{{ $formula->operator }}</td>
                                 @if ($formula->value)
                                <td>{{ $formula->value }}</td>
                                @else
                                <td>{{ $formula->employee->name }}</td>
                                @endif
                                <td class="text-right">
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('formula.delete', $formula->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                                        </form>
                                    </div>
                                </td>
                                </tr>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table -->
    </div><!-- /Page Content --> 
</div> 
<!-- /Page Wrapper -->
              
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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



