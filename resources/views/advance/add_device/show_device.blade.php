
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
                    <h3 class="page-title">Add Device</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Advance Loan/Add Device</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
					<a href="" class="btn add-btn" data-toggle="modal" data-target="#add_device"><i class="fa fa-plus"></i>Add Device</a>
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
                                <th>Device Type</th>
                                <th>Amount</th>
                                <th>Action</th> 
                                </tr>
                                </thead>
                                    <tbody>
                                        @foreach($device as $key => $item) 
                                        <tr>
                                            <th style="width: 30px;">
                                                <label>
                                                    <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{$key + 1}}</span>
                                                </label>
                                            </th>
                                            <td>{{$item->type}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td class="text-right">
                                            <div class="d-flex align-items-center">
                                                <a href="{{route('device.edit', $item)}}" data-toggle="modal" data-target="#edit_device{{$item->id}}">
                                                    <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                                </a>
                                            <span class="icon-spacing"></span>
                                            <form action="{{ route('device.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit device -->
                                <form method="POST" action="{{ route('device.update', $item) }}">
                                @csrf
                                @method('PUT')
                                <div id="edit_device{{$item->id}}"class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Device</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Device Type<span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text"  name="type" value="{{ $item->type }}">
                                                                        @error('type')
                                                                        <small class="text-danger">{{message}} </small>
                                                                        @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Amount<span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text"  name="amount" value="{{ $item->amount }}">
                                                                        @error('type')
                                                                        <small class="text-danger">{{message}} </small>
                                                                        @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer justify-content-start">
                                                <button type="submit" class="btn btn-primary">Update Device</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form> 
                                <!-- Edit Device -->
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
</div>
<!-- /Page Content -->
<!-- Add new department -->
<form method="POST" action="{{ route('device.store') }}">
@csrf
<div id="add_device" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Device Type<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  name="type" >
                                        @error('type')
                                        <small class="text-danger">{{message}} </small>
                                        @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Amount<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  name="amount" >
                                        @error('type')
                                        <small class="text-danger">{{message}} </small>
                                        @enderror
                            </div>
                        </div>
                    </div>
                </div>
             <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-primary">Add Device</button>
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





















