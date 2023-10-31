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
                            <h3 class="page-title">Leave Type</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Leave Management/Leave Type</li>
                            </ul>
                        </div>
                        
                        <div class="col-auto float-right ml-auto">
						<a href="{{route('role.create')}}" class="btn add-btn" data-toggle="modal" data-target="#add_leave_type"><i class="fa fa-plus"></i>Add Leave Type</a>
						</div>
                        <div class="col-auto float-right ml-auto">
                                <div class="view-icons">
									<a href="projects.html" class="btn btn-link border-2 border-solid border-secondary"><i class="bi bi-file-earmark-excel h3"></i></a>
									<a href="project-list.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-filetype-csv h3"></i></a>
                                    <a href="projects.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-file-pdf h3"></i></a>
									<a href="project-list.html" class="btn btn-link  border-2 border-solid border-secondary"><i class="bi bi-printer h3"></i></a>
								</div>
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
            <th>LeaveType Name</th>
            <th>Short Code</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @if($leavetypes->count() > 0)
            @foreach($leavetypes as $key => $leavetype)
          <tr>
          <th style="width: 30px;">
           <label>
            <input type="checkbox" id="selectAllCheckbox">
             <span>{{$key + 1}}</span>
            </label>
            </th>
            <td>{{ $leavetype->name }}</td>
            <td>{{ $leavetype->short_code}}</td>
            @if($leavetype->status == 1 )
            <td><button class="btn status-button" type="button">Active</button></td>
            @else
            <td><button class="btn inactive-button " type="button">Inactive</button></td>
            @endif
            <td class="text-right">
            <div class="d-flex align-items-center">
           
            <a href="{{route('leavetype.edit', $leavetype->id)}}" data-toggle="modal" data-target="#edit_leave_type{{$leavetype->id}}">
                <i class="bi bi-pencil h3" style="color:#4889CB"></i>
            </a>
            <span class="icon-spacing"></span>
            
            <form action="{{ route('leavetype.delete', $leavetype->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
            </form>
        </div>
       </td>
     </tr>
      <!-- Edit Leave Type -->
      <div id="edit_leave_type{{$leavetype->id}}" class="modal custom-modal fade" role="dialog">
            <form method="POST" action="{{ route('leavetype.update', $leavetype->id) }}">
                 @csrf
                 @method('patch')
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit LeaveType</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">LeaveType Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $leavetype->name) }}" required>
                                                @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Short Code<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="short_code" name="short_code" value="{{ old('short_code', $leavetype->short_code) }}" required>
                                                @error('short_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                            <label class="col-form-label form-select-md">Status</label>
                                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button  type="submit" class="btn btn-primary submit-btn">Update LeaveType</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
                <!-- /Edit LeaveType-->
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
    </div>
 <!-- /Page Content -->

                <!-- Add Leave Type -->
                <div id="add_leave_type" class="modal custom-modal fade" role="dialog">
                <form method="POST" action="{{ route('leavetype.store') }}">
                 @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New LeaveType</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">LeaveType Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name" required>
                                                @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Short Code<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="short_code" name="short_code" required>
                                                @error('short_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                            <label class="col-form-label form-select-md">Status</label>
                                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            </div>
                                        </div>
                                       
                                    </div>
                                  
                            </div>
                            <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary">Add Leave Type</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
                <!-- /Add LeaveType-->              
                
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



