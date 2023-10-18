
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
                            <h3 class="page-title">Hierarchy</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Setting Management/Hierarchy</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
       <div class="row mt-4">
      <div class="col-md-12 stretch-card">
      <div class="card">
      <div class="card-body">
      <div class="col-md-12">
      <div class="container table-responsive">  
         @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
      
                <!-- Add Hierarchy -->
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Hierarchy</h5>
								
							</div>
							<div class="modal-body">
								<form method="POST" action="{{ route('hierarchy.store')}}">
                                @csrf
                                <div class="row">
                                <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Hierarchy Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name">
                                                @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                    </div>
                                <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Level<span class="text-danger">*</span></label>
                                            <select name="level"  id="level" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="1">Level 1</option>
                                            <option value="2">Level 2</option>
                                            <option value="3">Level 3</option>
                                            </select>
                                            @error('level')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                                        @error('start_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror  
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                        @error('end_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror  
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Value<span class="text-danger">*</span></label>
                                            <select id="value" name="value" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
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
                                    </div>
                           
                          
                                    <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                <select  id="status" name="status" class="form-select custom-select" style="height:45px">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('status')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6" id="userField" style="display:none">
                                        <div class="form-group">
                                            <label class="col-form-label">Select User<span class="text-danger">*</span></label>
                                            <select id="user_id" name="user_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id}}">{{ $user->name }}</option>
                                            @endforeach
                                            </select>
                                            @error('employee_id')
                                                <small class="text-danger">{{ $message }}</small>
                                             @enderror

                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-start mt-3">
                                            <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                            &nbsp;  &nbsp;   &nbsp;
                                            <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                                        </div>
								</form>
						</div>
                 <!-- Add Hierarchy -->

    </div>
     </div>
    </div>
     </div>
    </div>
    </div>
     </div>
<!-- /Page Content -->             
</div> 
<!-- /Page Wrapper -->

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



