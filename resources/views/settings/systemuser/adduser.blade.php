@extends('layouts.index')

@section('content')
<style>
    .required-icon {
        color: red;
        margin-left: 5px;
    }
</style>
<div class="page-wrapper">		
	<!-- Page Content -->
	<div class="content container-fluid">
        <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">System User</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Setting/System Users</li>
                            </ul>
                    </div>
                </div>
            </div>
        <!-- /Page Header -->
		        <div class="row">
			        <div class="col-md-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add User</h4>   
                                        </div>
                                        <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Name:<span class="text-danger">*</span></label>
                                                            <input id="name" name="name" class="form-control" type="text"  required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Email:<span class="text-danger">*</span></label>
                                                            <input id="email" name="email" class="form-control" type="text"  required>
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Employee ID:<span class="text-danger">*</span></label>
                                                            <input id="employee_id" name="employee_id" class="form-control" type="text"  required>
                                                            @error('employee_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                        <label class="col-form-label">Department Name:</label>
                                                                <select id="department"  name="department_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select Department</option>
                                                                    @foreach ($departments as $department)
                                                                    <option value="{{ $department->id}}">{{ $department->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('department_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                               
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Section Name:</label>
                                                                <select id="section"  name="section_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                 <!-- Options will be dynamically added using JavaScript -->
                                                                </select>
                                                                @error('section_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Region:</label>
                                                                <select id="user_id"  name="region_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select Region</option>
                                                                    @foreach ($region as $region)
                                                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('region')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                               
                                                        </div> 
                                                    </div> 
                                                   
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Role:</label>
                                                                <select id="user_id"  name="role" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select Role</option>
                                                                    @foreach ($roles as $role)
                                                                    <option value="{{ $role->id}}">{{ $role->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('role')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                             
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Designation:</label>
                                                                <select id="user_id"  name="designation_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select Designation</option>
                                                                    @foreach ($designations as $designation)
                                                                    <option value="{{ $designation->id}}">{{ $designation->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('designation_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                              
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Grade:</label>
                                                                <select id="user_id"  name="grade_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select Grade</option>
                                                                    @foreach ($grades as $grade)
                                                                    <option value="{{ $grade->id}}">{{ $grade->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('grade_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                               
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Gender:</label>
                                                                <select id="gender"  name="gender" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select Gender</option>
                                                                    <option value="M">Male</option>
                                                                    <option value="F">Female</option>
                                                                    <option value="A">All</option>
                                                                </select>
                                                                @error('gender')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                               
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Employement Type:</label>
                                                                <select id="employment_type"  name="employment_type" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="" disabled selected>Select EmployeeType</option>
                                                                    <option value="probation_period">Probation</option>
                                                                    <option value="regular_period">Regular</option>
                                                                    <option value="contract_period">Contract</option>
                                                                    <option value="notice_period">Notice</option>
                                                                </select>
                                                                @error('employment_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                                
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        <div class="modal-footer justify-content-start mt-3">
                                            <button type="submit" class="btn btn-primary">{{__('Register')}}</button>
                                            @if(Route::has('password.request'))
                                                <a class="btn btn-link" href="#">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                            </form> 
                            <!-- Add New Department -->
                                                        
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
    // Get references to the department and section dropdowns
    var departmentDropdown = document.getElementById('department');
    var sectionDropdown = document.getElementById('section');

    // Add an event listener to the department dropdown
    departmentDropdown.addEventListener('change', function() {
        var departmentId = this.value;

        // Clear existing options
        sectionDropdown.innerHTML = '';

        // Make an AJAX request to fetch sections based on the selected department
        fetch('/sections/' + departmentId)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                var sections = data.sections;

                // Add a default "Select Section" option
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Section';
                sectionDropdown.appendChild(defaultOption);

                // Populate the section dropdown with fetched data
                sections.forEach(function(section) {
                    var option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    sectionDropdown.appendChild(option);
                });
            })
            .catch(function(error) {
                console.error('Error fetching sections:', error);
            });
    });
</script>
@endsection