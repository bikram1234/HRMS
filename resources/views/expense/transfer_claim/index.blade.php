

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
                    <h3 class="page-title">Transfer Cliam</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense Management/Transfer Cliam</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_expense"><i class="fa fa-plus"></i> Apply Transfer Cliam</a>
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
                                                <input type="checkbox">
                                                <span>SI</span>
                                            </label>
                                        </th>
                                        <th>Employee ID</th>
                                        <th>Transfer Claim Type</th>
                                        <th>Claim Amount</th>
                                        <th>Current Location</th>
                                        <th>New Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    @foreach ($products as $key =>$product)
                                    <tr>
                                        <th style="width: 30px;">
                                            <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                <span>{{ $key + 1 }}</span>
                                            </label>
                                    
                                        </th>
                                        <td>{{ $product->employee_id }}</td>
                                        <td>{{ $product->transfer_claim_type }}</td>
                                        <td>{{ $product->claim_amount }}</td>
                                        <td>{{ $product->current_location }}</td>
                                        <td>{{ $product->new_location }}</td>
                                        <td>{{ $product->status }}</td>

                                        <td>
                                            <a type="button"  class="btn btn-success " data-toggle="modal" data-target="#acceptexpense{{ $product->id}}">Approved</a>
                                            <a type="button"  class="btn btn-danger" data-toggle="modal" data-target="#declineexpense{{ $product->id}}">Reject</a> 
                                            
                                        </td>


                                         <!--Leave approved  -->
                                         <div id="acceptexpense{{ $product->id}}" class="modal custom-modal fade" role="dialog">
                                            <form method="POST" action="{{ route('transfer.approve', ['id' => $product->id]) }}">
                                                @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Expense Approval</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <h4>Are you sure you want to approve this Expense?</h4>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                        <button type="submit" name="save" class="btn btn-primary">Approved Expense</button>
                                                        <button  name="cancel" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        <!-- / Leave approved-->  

                                         <!--Leave Reject-->
                                         <div id="declineexpense{{ $product->id}}" class="modal custom-modal fade" role="dialog">
                                            <form method="POST" action="{{ route('transfer.reject', ['id' => $product->id]) }}">
                                            @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Expense Reject</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <h4>Are you sure you want to reject this Expense?</h4>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                        <button type="submit" name="save" class="btn btn-primary">Reject Expense</button>
                                                        <button  name="cancel" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- / Leave Reject-->
                                       
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
<form action="{{ route('products.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div id="add_product" class="modal custom-modal fade" role="dialog">
    
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apply Transfer Cliam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                    <div class="row">
                        <!-- Employee Type -->
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="col-form-label" for="employeeID">Employee ID<span class="text-danger">*</span></label>
                            <input type="text" name="employee_id" class="form-control" placeholder="Employee ID" value="{{ Auth::user()->employee_id }}" readonly>
                            <input type="hidden" name="user_id" class="form-control" placeholder="User ID" value="{{ Auth::user()->id }}" readonly>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="col-form-label" for="designation">Designation<span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" value="{{ Auth::user()->designation->name }}" readonly>

                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="col-form-label" for="department">Department<span class="text-danger">*</span></label>
                            <input type="text" name="department" class="form-control" value="{{ Auth::user()->department->name }}" readonly>

                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="col-form-label" for="department">Basic Pay<span class="text-danger">*</span></label>
                        @if(Auth::user()->grade && Auth::user()->grade->basicPay)
                            <input type="text" name="basic_pay" class="form-control" value="{{ Auth::user()->grade->basicPay->amount }}" readonly>
                        @endif
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

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Transfer Claim Type<span class="text-danger">*</span></label>
                            <select  name="transfer_claim_type" id="transferClaimTypeSelect" class="form-select  form-select-md" aria-label="Default select example" style="height:45px" >
                            <option value="">Select Transfer Claim</option>
                            <option value="Transfer Grant">Transfer Grant</option>
                            <option value="Carriage Charge">Carriage Charge</option>
                            </select>
                        </div>
                    </div>

                     <!-- Travel From -->
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Current Location<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="current_location" id="current_location" >
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">New Location<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="new_location" id="new_location" >
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Claim Amount<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="claim_amount" id="claim_amount" >
                        </div>
                    </div>

                    <div class="col-sm-12" id="distanceField" style="display:none;">
                        <div class="form-group">
                            <label class="col-form-label">Distance(KM)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="distance_km" id="claim_amount" >
                        </div>
                    </div>
                </div>

                        <!-- Upload Attachment -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Attachments</label>
                                <input class="form-control" type="file" name="attachement" id="attachment">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end mt-2">
                    <button type="submit" name="save" class="btn btn-primary">Apply Transfer Cliam</button>
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
    $(document).ready(function() {
    var table = $('#example').DataTable({
        // DataTable options and configurations go here
    });
});
</script>


<script>
        const transferClaimTypeSelect = document.getElementById('transferClaimTypeSelect');
        const distanceField = document.getElementById('distanceField');

        // Function to show/hide the Distance input field based on Transfer Claim Type
        function toggleDistanceField() {
            if (transferClaimTypeSelect.value === 'Carriage Charge') {
                distanceField.style.display = 'block';
            } else {
                distanceField.style.display = 'none';
            }
        }

        // Add event listener to the Transfer Claim Type dropdown
        transferClaimTypeSelect.addEventListener('change', toggleDistanceField);

        // Initial check when the page loads
        toggleDistanceField();
    </script>



@endsection

