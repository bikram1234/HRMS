
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
@if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

              
    @if(session('error'))
            <div id="error-message" class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
            
            <!-- Page Content -->
            <div class="content container-fluid">
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">DSA  Approval</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Expense Management/DSA Approval</li>
                            </ul>
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
                                <option>Pending</option>
                                <option>Approved</option>
                                <option>Reject</option>
                            </select>
                            <label class="focus-label">Select Status</label>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">  
                        <a href="#" class="btn btn-success approved-button w-100" data-toggle="modal" data-target="#edit_type">Approve</a>
                    </div>  
                    <div class="col-sm-6 col-md-3">  
                        <a href="#" class="btn btn-danger reject-button w-100">Reject</a>
                    </div>    
                </div> -->
            <!-- Search Filter -->
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
                                        <th>Employee</th>
                                        <th>Total Amount Adjusted</th>
                                        <th>Net Payable Amount</th>
                                        <th>Balance Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($expenseApplications as $key => $expenseApplication)
                                    <tr>
                                        <th style="width: 30px;">
                                            <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{ $key + 1 }}</span>
                                            </label>
                                        </th>
                                        <td>{{ $expenseApplication->user->name }}</td>
                                        <td>{{ $expenseApplication->total_amount_adjusted }}</td>
                                        <td>{{ $expenseApplication->net_payable_amount }}</td>
                                        <td>{{ $expenseApplication->balance_amount }}</td>
                                        <td>{{ $expenseApplication->status }}</td>
                                        <td>
                                            <a type="button"  class="btn btn-success " data-toggle="modal" data-target="#acceptexpense{{ $expenseApplication->id}}">Approved</a>
                                            <a type="button"  class="btn btn-danger" data-toggle="modal" data-target="#declineexpense{{ $expenseApplication->id}}">Reject</a> 
                                            <a href="{{ route('dsa-settlement.view', ['id' => $expenseApplication->id]) }}"  type="button"  class="btn btn-danger" data-toggle="modal" data-target="">View</a> 

                                        </td>
                                        <!--Leave approved  -->
                                        <div id="acceptexpense{{ $expenseApplication->id}}" class="modal custom-modal fade" role="dialog">
                                            <form method="POST" action="{{ route('dsa.approve', ['id' => $expenseApplication->id]) }}">
                                                @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">DSA Approval</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <h4>Are you sure you want to approve this DSA ?</h4>
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
                                        <div id="declineexpense{{ $expenseApplication->id}}" class="modal custom-modal fade" role="dialog">
                                            <form method="POST" action="{{ route('dsa.reject', ['id' => $expenseApplication->id]) }}">
                                            @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">DSA Reject</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <h4>Are you sure you want to reject this DSA?</h4>
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
<!-- /Page Wrapper -->

                
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


@endsection



