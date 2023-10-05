

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


.word {
 margin-left: 10px; 
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
                            <h3 class="page-title">Leave Policy</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Leave Management/Leave Policy</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                                <div class="view-icons">
									<a href="projects.html" class="btn btn-link border-2 border-solid border-secondary"><i class="bi bi-file-earmark-excel h4"></i></a>
									<a href="project-list.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-filetype-csv h4"></i></a>
                                    <a href="projects.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-file-pdf h4"></i></a>
									<a href="project-list.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-printer h4"></i></a>
								</div>
						</div>
                        <div class="col-auto float-right ml-auto">
						<a href="{{route('leavepolicy.create')}}" class="btn add-btn" data-toggle="modal" data-target="#add_leavepolicy"><i class="fa fa-plus"></i> Add LeavePolicy</a>
						</div>
                    </div>
                </div>
                <!-- /Page Header -->
                
        <div class="row">
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
                                <th>Policy Name</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                             </tr>
                            </thead>
                              <tbody>
                                @if($leave_policies->count() > 0)
                                @foreach($leave_policies as $key => $leave_policy)
                                <tr>
                                <th style="width: 30px;">
                                <label>
                                    <input type="checkbox" id="selectAllCheckbox">
                                    <span>{{ $key + 1 }}</span>
                                    </label>
                                    </th>
                                        <td>{{ $leave_policy->policy_name }}</td>
                                        <td>{{ $leave_policy->leavetype->name }}</td>
                                        <td>{{ $leave_policy->start_date }}</td>
                                        <td>{{ $leave_policy->end_date }}</td>
                                        @if($leave_policy->status == 1)
                                        <td><button class="btn status-button" type="button">Enforce</button></td>
                                        @else
                                        <td><button class="btn inactive-button " type="button">Draft</button></td>
                                        @endif
                                        <td class="text-right">
                                        <div class="d-flex align-items-center">
                                    
                                        <a href="" data-toggle="modal" data-target="">
                                            <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                        </a>
                                        <span class="icon-spacing"></span>
                                        <a href="{{ route('leavePolicy.view', ['leave_id' => $leave_policy->leave_id])}}">  <i class="bi bi-eye-fill h3"></i></a> 
                                        </div>
                                        </td>
            
                                    </tr>
                            @endforeach
                            @endif
                    </tbody>
                </table>
            </div>
         </div>
        </div>
     </div>
</div>
</div>

                <!-- Add Leavepolicy-->
                <div id="add_leavepolicy" class="modal custom-modal fade" role="dialog">
                    <form method="POST" action="{{ route('leavepolicy.store') }}">
                         @csrf
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Leave Policy</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card tab-box">
                                    <div class="row user-tabs">
                                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                            <ul class="nav nav-tabs nav-tabs-bottom">
                                                <li class="nav-item"><a href="#hierarchyFields" data-toggle="tab" class="nav-link active">Leave Policy</a></li>
                                                <li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link">Leave Plan</a></li>
                                                <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Year End Processing</a></li>
                                                <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Summary</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <div class="form-group" id="hierarchyFields">
                                            <label class="col-form-label" for="leave_id">Leave Type<span class="text-danger">*</span></label>
                                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="leave_id" id="leave_id">
                                            @foreach($leavetypes as $leavetype)
                                            <option value="{{ $leavetype->id }}">{{ $leavetype->name}}</option>
                                            @endforeach
                                            </select>
                                            @error('leave_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Policy Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="policy_name" name="policy_name">
                                                @error('policy_name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Policy Decription</label>
                                                <div class="form-floating">
                                                <textarea class="form-control"  style="height: 100px" id="policy_description" name="policy_description"></textarea>
                                                @error('policy_description')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                        <div class="form-group">
										<label for="start_date">Start Date <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input  name="start_date" id="start_date" class="form-control datetimepicker" type="date">
                                            @error('start_date')
                                                <small class="text-danger">{{ $message }}</small>
                                             @enderror
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
										<label>End Date <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input class="form-control datetimepicker" id="end_date" name="end_date"  type="date">
                                            @error('end_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                            <label class="col-form-label form-select-md">Status</label>
                                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
                                            <option value="1">Enforce</option>
                                            <option value="0">Draft</option>
                                            </select>
                                            @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            </div>
                                        </div>
                                    </div>
                                        <label class="mt-3">
                                        <input type="checkbox" id="is_information_only" name="is_information_only">
                                        <span>Is Information only</span>
                                        @error('is_information_only')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        </label>

                                         <!-- Modal footer -->
                                        <div class="modal-footer justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary">Previous</button>
                                            <button type="submit" class="btn btn-primary">Add Policy</button>
                                            <button type="button" class="btn btn-secondary"data-dismiss="modal">Cancel</button>
                                        </div>
                                       
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
<!-- End Table -->
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
<script>
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>







@endsection



