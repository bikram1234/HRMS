
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
                            <h3 class="page-title">Hierarchy</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Setting Management/Hierarchy</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                        <a href="" class="btn add-btn" data-toggle="modal" data-target="#add_level"><i class="fa fa-plus"></i>Add Level</a>
						</div>                  
                    </div>
                </div>
                <!-- /Page Header -->
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
                                        <th>Hierarchy Name</th>
                                        <th>Level</th>  
                                        <th>Value</th> 
                                        <th>Employee</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>   
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($levels as $key => $level)
                                    <tr>
                                    <td style="width: 30px;">
                                        <label>
                                            <input type="checkbox" id="selectAllCheckbox">
                                            <span>{{ $key + 1 }}</span>
                                        </label>
                                    </td>
                                    <td>{{ $hierarchy->name }}</td>
                                    <td>{{ $level->level}}</td>
                                    <td>{{ $level->value}}</td>
                                    @if ($level->user_id)
                                    <td>{{ $level->employeeName->name}}</td>
                                    @else
                                    <td>No Employee Assigned</td>
                                    @endif
                                    <td>{{ $level->start_date }}</td>
                                    <td>{{ $level->end_date }}</td>
                                    @if($level->status == 1)
                                        <td><button class="btn status-button" type="button">Active</button></td>
                                            @else
                                        <td><button class="btn inactive-button " type="button">Inactive</button></td>
                                    @endif
                                    <td class="text-right">
                                        <div class="d-flex align-items-center">
                                            <a href="">
                                                <i class="bi bi-pencil h3" style="color:#4889CB"></i></a>
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

<!-- Add Level -->
<div id="add_level" class="modal custom-modal fade" role="dialog">
    <form method="POST" action="{{ route('level.store', ['hierarchyId' => $hierarchy->id] ) }}">
    @csrf
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label form-select-md">Level</label>
                                        <select  name="level" id="level" class="form-select" aria-label="Default select example" style="height:45px">
                                            <option disabled selected>Select Level</option>
                                            <option value="1">Level 1</option>
                                            <option value="2">Level 2</option>
                                            <option value="3">Level 3</option>
                                        </select>
                                    @error('level')
                                        <small class="text-danger">{{message}} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label form-select-md">Value</label>
                                        <select  name="value" id="value" class="form-select" aria-label="Default select example" style="height:45px">
                                            <option disabled selected>Select Value</option>
                                            <option value="IS">Immediate Supervisor</option>
                                            <option value="SH">Section Head</option>
                                            <option value="DH">Department Head</option>
                                            <option value="MM">Management</option>
                                            <option value="HR">Human Resource</option>
                                            <option value="FH">Finance Head</option>
                                        </select>
                                    @error('value')
                                        <small class="text-danger">{{message}} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label form-select-md">Select User</label>
                                        <select  name="user_id" id="user_id" class="form-select" aria-label="Default select example" style="height:45px">
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id}}">{{ $user->name}}</option>
                                            @endforeach
                                        </select>
                                    @error('user_id')
                                        <small class="text-danger">{{message}} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                                    @error('start_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror  
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    @error('end_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror  
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select  id="status" name="status" class="form-select custom-select" style="height:45px">
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
                            <button type="submit" name="save" class="btn btn-primary">Add Level</button>
                            <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                        </div>
                </div>    
            </div> 
        </div>
        </form> 
    </div>
<!-- End Add Level -->


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
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'MM-DD-YYYY', // Set the desired date format
        // Add any other options you need
    });
});
</script>
<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>


@endsection



