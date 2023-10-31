
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
                    <h3 class="page-title">Add Vehicle</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense/Add Vehicle</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
					<a href="" class="btn add-btn" data-toggle="modal" data-target="#add_vehicle"><i class="fa fa-plus"></i>Add New Vehicle</a>
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
                                <th>Vehicle Number</th>
                                <th>Vehicle Type</th>
                                <th>Vehicle Mileage</th>
                                <th>Action</th> 
                                </tr>
                                </thead>
                                    <tbody>
                                        @foreach($vehicles as $key => $vehicle) 
                                        <tr>
                                            <th style="width: 30px;">
                                                <label>
                                                    <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{$key + 1}}</span>
                                                </label>
                                            </th>
                                            <td>{{ $vehicle->vehicle_number }}</td>
                                            <td>{{ $vehicle->vehicle_type }}</td>
                                            <td>{{ $vehicle->vehicle_mileage }}</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{route('vehicles.edit', $vehicle->id)}}" data-toggle="modal" data-target="#edit_vehicle{{$vehicle->id}}">
                                                        <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>  
                                        <!-- Edit new vehicle -->
                                <form method="POST" action="{{ route('vehicles.update', $vehicle) }}">
                                @csrf
                                @method('PUT')
                                <div id="edit_vehicle{{$vehicle->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Vehicle</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Vehicle Number<span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text"  id="vehicle_number" name="vehicle_number" value="{{ $vehicle->vehicle_number }}"  required>
                                                                        @error('vehicle_name')
                                                                        <small class="text-danger">{{message}} </small>
                                                                        @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text"  id="vehicle_type" name="vehicle_type" value="{{ $vehicle->vehicle_type }}" required>
                                                                        @error('vehicle_type')
                                                                        <small class="text-danger">{{message}} </small>
                                                                        @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Vehicle Mileage<span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text"  id="vehicle_mileage" name="vehicle_mileage" value="{{ $vehicle->vehicle_mileage }}" required>
                                                                        @error('vehicle_mileage')
                                                                        <small class="text-danger">{{message}} </small>
                                                                        @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer justify-content-start">
                                                <button type="submit" class="btn btn-primary">Update Vehicle</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form> 
                                <!-- Update New vehicle -->
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
<!-- Add new vehicle -->
<form method="POST" action="{{ route('vehicles.store') }}">
@csrf
<div id="add_vehicle" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Vehicle Number<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  id="vehicle_number" name="vehicle_number" required>
                                        @error('vehicle_name')
                                        <small class="text-danger">{{message}} </small>
                                        @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  id="vehicle_type" name="vehicle_type" required>
                                        @error('vehicle_type')
                                        <small class="text-danger">{{message}} </small>
                                        @enderror
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Vehicle Mileage<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  id="vehicle_mileage" name="vehicle_mileage" required>
                                        @error('vehicle_mileage')
                                        <small class="text-danger">{{message}} </small>
                                        @enderror
                            </div>
                        </div>
                    </div>
                </div>
             <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-primary">Add Vehicle</button>
            </div>
            </div>
        </div>
    </div>
    </form> 
<!-- Add New vehicle -->
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





















