

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
                    <h3 class="page-title">Expense History</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense Management/Expense History</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_expense"><i class="fa fa-plus"></i> Apply Expense</a>
                </div>
                
            </div>
        </div>
        <!-- /Page Header -->

                <!-- Search Filter -->
                <!-- <div class="row filter-row">
						<div class="col-sm-6 col-md-3"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option>-</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
									<option>MR.Kinzang Dorji</option>
								</select>
								<label class="focus-label">Employee Name</label>
							</div>
						</div>   
                    </div> -->
					<!-- /Search Filter -->      
    <div class="row mt-4">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="container table-responsive">  
                        @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                            <table id="example" class="table table-striped custom-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">
                                            <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                <span>SI</span>
                                            </label>
                                        </th>
                                        <th>Employee</th>
                                        <th>Expense Date</th>
                                        <th>Expense Type</th>
                                        <th>Expense Amount</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($userApplications as  $key => $userApplication)
                                    <tr>
                                        <th style="width: 30px;">
                                    <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        <span>{{ $key + 1 }}</span>
                                    </label>
                                        </th>
                                        <td>{{ $userApplication->user->name}}</td>
                                        <td>{{ $userApplication->application_date }}</td>
                                        <td>{{ $userApplication->expenseType->name  }}</td>
                                        <td>{{ number_format($userApplication->total_amount, 2) }}</td>
                                        <td>{{ $userApplication->description }}</td>
                                        <td>
                                        @if ($userApplication->status === 'pending')
                                            <button class="btn btn-warning">Pending</button>
                                        @elseif ($userApplication->status === 'approved')
                                            <button class="btn btn-success">Approved</button>
                                        @elseif ($userApplication->status === 'rejected')
                                            <button class="btn btn-danger">Rejected</button>
                                        @endif
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
</div>
<!-- /Page Content -->
</div>
<!-- Page Wrapper -->

<!--/Add Expense -->
<form action="{{ route('submit-application')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div id="add_expense" class="modal custom-modal fade" role="dialog">
    
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apply Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                    <div class="row">
                        <!-- Expense Type -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Expense Type<span class="text-danger">*</span></label>
                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="expense_type_id" id="expense_type_id">
                            <option value="" selected disabled>Select Type</option>
                            @foreach ($expenseTypes as $expenseType)
                            <option value="{{ $expenseType->id}}">{{ $expenseType->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Expense date -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label" for="start_date">Expense Date<span class="text-danger">*</span></label>
                            <input type="date" id="application_date" name="application_date" class="form-control" required>
                            @error('application_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror  
                        </div>
                    </div>

                    <!-- Expense Amount -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Expense Amount<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="total_amount" id="total_amount" >
                        </div>
                    </div>
                        <!-- Description -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label"> Decription</label>
                                <div class="form-floating">
                                <textarea class="form-control" name="description" id="description" style="height: 100px"></textarea>
                                </div>
                            </div>
                        </div>

                    <!-- Extra Field for Conveyance Expense (initially hidden) -->
                    <!-- Travel Type -->
                <div id="conveyanceFields" style="display: none">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Travel Type<span class="text-danger">*</span></label>
                            <select  name="travel_type" id="travel_type" class="form-select  form-select-md" aria-label="Default select example" style="height:45px" >
                            <option value="Domestic">Domestic</option>
                            </select>
                        </div>
                    </div>

                    <!-- Travel Mode -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Travel Type<span class="text-danger">*</span></label>
                            <select  name="travel_mode" id="travel_mode" class="form-select  form-select-md" aria-label="Default select example" style="height:45px" >
                            <option value="car">Car</option>
                            <option value="bike">Bike</option>
                            <option value="plane">Plane</option>
                            <option value="train">Train</option>
                            </select>
                        </div>
                    </div>

                    <!-- Travel from date -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label" for="start_date">Travel From Date<span class="text-danger">*</span></label>
                            <input type="date" id="travel_from_date" name="travel_from_date" class="form-control" required>
                            @error('travel_from_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror  
                        </div>
                    </div>
                      <!-- Travel to date -->
                      <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label" for="start_date">Travel To Date<span class="text-danger">*</span></label>
                            <input type="date" id="travel_to_date" name="travel_to_date" class="form-control" required>
                            @error('travel_to_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror  
                        </div>
                    </div>

                     <!-- Travel From -->
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Travel From<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="travel_from" id="travel_from" >
                        </div>
                    </div>

                     <!-- Travel To-->
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Travel To<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="travel_to" id="travel_to" >
                        </div>
                    </div>
                </div>

                        <!-- Upload Attachment -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Attachments</label>
                                <input class="form-control" type="file" name="attachement" id="attachment">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end mt-2">
                    <button type="submit" name="save" class="btn btn-primary">Apply Expense</button>
                    <button type="submit" name="cancel" class="btn btn-secondary"data-dismiss="modal">Cancel</button>
                    </div> 
                </div>
               
            </div> 
            </form>
<!-- Add Expense Modal -->


                
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

{{-- <script>
        document.getElementById('expense_type_id').addEventListener('change', function () {
            var selectedValue = this.value; // Get the selected option's value (id)
            var conveyanceFields = document.getElementById('conveyanceFields');
            
            // Determine the name of the selected option based on its value
            var selectedName = document.querySelector('#expense_type_id [value="' + selectedValue + '"]').text;
    
            if (selectedName === 'Conveyance Expense') { // Check for the name 'Conveyance Expense'
                conveyanceFields.style.display = 'block';
            } else {
                conveyanceFields.style.display = 'none';
            }
        });
    </script> --}}
    <script>
        document.getElementById('expense_type_id').addEventListener('change', function () {
            var selectedValue = this.value; // Get the selected option's value (id)
            var conveyanceFields = document.getElementById('conveyanceFields');
            
            // Determine the name of the selected option based on its value
            var selectedName = document.querySelector('#expense_type_id [value="' + selectedValue + '"]').text;
    
            if (selectedName === 'Conveyance Expense') {
                conveyanceFields.style.display = 'block';
                // Add the 'required' attribute to the necessary fields
                document.getElementById('travel_type').setAttribute('required', 'required');
                document.getElementById('travel_mode').setAttribute('required', 'required');
                document.getElementById('travel_from_date').setAttribute('required', 'required');
                document.getElementById('travel_to_date').setAttribute('required', 'required');
                document.getElementById('travel_from').setAttribute('required', 'required');
                document.getElementById('travel_to').setAttribute('required', 'required');
                // Add required attribute to other fields as needed
            } else {
                conveyanceFields.style.display = 'none';
                // Remove the 'required' attribute from the fields
                document.getElementById('travel_type').removeAttribute('required');
                document.getElementById('travel_mode').removeAttribute('required');
                document.getElementById('travel_from_date').removeAttribute('required');
                document.getElementById('travel_to_date').removeAttribute('required');
                document.getElementById('travel_from').removeAttribute('required');
                document.getElementById('travel_to').removeAttribute('required');
                // Remove required attribute from other fields as needed
            }
        });
    </script>


@endsection



