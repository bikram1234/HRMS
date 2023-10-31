
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
                    <h3 class="page-title">Department</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Work Structure/Department</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
					<a href="" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i>Add New Departent</a>
				</div>                                             
            </div>
        </div>
    <!-- /Page Header -->

    <!-- Table -->
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
                                <th>Department Name</th>
                                <th>Department Head</th>
                                <th>Status</th>
                                <th>Action</th> 
                                </tr>
                                </thead>
                                    <tbody>
                                        @if($departments->count() > 0)
                                        @foreach($departments as $key => $department) 
                                        <tr>
                                            <th style="width: 30px;">
                                                <label>
                                                    <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{$key + 1}}</span>
                                                </label>
                                            </th>
                                            <td>{{$department->name}}</td>
                                            <td></td>
                                                @if($department->status == 1)
                                            <td><button class="btn status-button" type="button">Active</button></td>
                                                @else
                                            <td><button class="btn inactive-button " type="button">Inactive</button></td>
                                                @endif
                                            <td class="text-right">
                                            <div class="d-flex align-items-center">
                                                <a href="{{route('department.edit', $department->id)}}" data-toggle="modal" data-target="#edit_type{{$department->id}}">
                                                    <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                                </a>
                                            <span class="icon-spacing"></span>
                                            <form action="{{ route('department.delete', $department->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <!-- Edit Department-->
                            <div id="edit_type{{$department->id}}" class="modal custom-modal fade" role="dialog">
                                <form method="POST" action="{{ route ('department.update',  $department->id) }}">
                                    @csrf
                                    @method('patch')
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Department</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Department Name<span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text"  id="name" name="name" value="{{old('name', $department->name)}}" required>
                                                                    @error('name')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Department Head</label>
                                                                <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                                    <option value="0">24(Sangay Tenzin)</option>
                                                                    <option value="1">24(Sangay Tenzin)</option>
                                                                    <option value="2">24(Sangay Tenzin)</option>
                                                                    <option value="3">24(Sangay Tenzin)</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label form-select-md">Status</label>
                                                                <select class="form-select" aria-label="Default select example" style="height:45px" name="status">
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
                                                <button type="submit" class="btn btn-primary">Update Department</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /Edit Department -->  
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
<!-- Table -->
</div>
<!-- /Page Content -->
<!-- Add new department -->
<form method="POST" action="{{ route('department.store') }}">
@csrf
<div id="add_department" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Department Name<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" value="" id="name" name="name" required>
                                        @error('name')
                                        <small class="text-danger">{{message}} </small>
                                        @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Department Head</label>
                                    <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                        <option value="0">24(Sangay Tenzin)</option>
                                        <option value="1">24(Sangay Tenzin)</option>
                                        <option value="2">24(Sangay Tenzin)</option>
                                        <option value="3">24(Sangay Tenzin)</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label form-select-md">Status</label>
                                    <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                @error('name')
                                    <small class="text-danger">{{message}} </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
             <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-primary">Add Department</button>
            </div>
            </div>
        </div>
    </div>
    </form> 
<!-- Add New Department -->
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





















