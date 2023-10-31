
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
                            <h3 class="page-title">Leave Approval</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Leave Management/Leave Approval</li>
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
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($leaveApplications as $key => $leaveApplication)
                                    <tr>
                                        <th style="width: 30px;">
                                            <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{ $key + 1 }}</span>
                                            </label>
                                        </th>
                                        <td>{{ $leaveApplication->user->name }}</td>
                                        <td>{{ $leaveApplication->start_date}}</td>
                                        <td>{{ $leaveApplication->end_date}}</td>
                                        <td>{{ $leaveApplication->level1 }}</td>
                                        <td>
                                            @if ($leaveApplication->status === 'pending')
                                                <button class="btn btn-warning">Pending</button>
                                            @elseif ($leaveApplication->status === 'approved')
                                                <button class="btn btn-success">Approved</button>
                                            @elseif ($leaveApplication->status === 'rejected')
                                                <button class="btn btn-danger">Rejected</button>
                                            @endif
                                        </td>
                                             @if($leaveApplication->status === 'pending')
                                        
                                        <td>
                                            <a type="button"  class="btn btn-success " data-toggle="modal" data-target="#acceptleave{{ $leaveApplication->id}}">Approved</a>
                                        </td>
                                        <!--Leave approved  -->
                                        <div id="acceptleave{{ $leaveApplication->id}}" class="modal custom-modal fade" role="dialog">
                                            <form method="POST" action="{{ route('leave.approve', ['id' => $leaveApplication->id]) }}">
                                                @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Leave Approval</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <h4>Are you sure you want to approve this leave?</h4>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                        <button type="submit" name="save" class="btn btn-primary">Approved Leave</button>
                                                        <button  name="cancel" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        <!-- / Leave approved-->  
                                        <td class="mr-">
                                        <a type="button"  class="btn btn-danger" data-toggle="modal" data-target="#declineleave{{ $leaveApplication->id}}">Reject</a> 
                                        </td>

                                        <!--Leave Reject-->
                                        <div id="declineleave{{ $leaveApplication->id}}" class="modal custom-modal fade" role="dialog">
                                            <form method="POST" action="{{ route('leave.decline', ['id' => $leaveApplication->id]) }}">
                                            @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Leave Reject</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <h4>Are you sure you want to reject this leave?</h4>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                        <button type="submit" name="save" class="btn btn-primary">Reject Leave</button>
                                                        <button  name="cancel" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- / Leave Reject-->
                                        @endif

                                        <td class="text-right">
                                            <div class="d-flex align-items-center">
                                                <a href="" data-toggle="modal" data-target="#edit_type">
                                                    <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                                </a>
                                            <span class="icon-spacing"></span>
                                            <form action="" method="POST" class="d-inline">
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



