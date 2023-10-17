
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
						<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_hierarchy"><i class="fa fa-plus"></i>Add New Hierarchy </a>
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
            <th>Action</th>   
          </tr>
        </thead>
        <tbody>
        @foreach($hierarchies as $key => $hierarchy)
        <tr>
            <td style="width: 30px;">
                <label>
                    <input type="checkbox" id="selectAllCheckbox">
                    <span>{{ $key + 1 }}</span>
                </label>
            </td>
            <td>{{ $hierarchy->name }}</td>
            <td class="text-right">
                <div class="d-flex align-items-center">
                            <a href="{{ route('hierarchy.show', ['hierarchy_id' => $hierarchy->id])}}">
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
            <!-- /Page Content -->

                <!-- Edit Hierarchy -->
                <div id="edit_type" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Hierarchy</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form>
                                <div class="row">
                                <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Hierarchy Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" value="0">
                                            </div>
                                    </div>
                                <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Level<span class="text-danger">*</span></label>
                                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="0">Level1</option>
                                            <option value="1">Level2</option>
                                            <option value="2">Level3</option>
                                            <option value="3">Level4</option>
                                            <option value="3">Level5</option>
                                            <option value="3">Level6</option>
                                            <option value="3">Level7</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Value<span class="text-danger">*</span></label>
                                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="0">1</option>
                                            <option value="1">2</option>
                                            <option value="2">3</option>
                                            <option value="3">4</option>
                                            <option value="3">5</option>
                                            <option value="3">6</option>
                                            <option value="3">7</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
										<label>Start Date <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text">
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
										<label>End Date <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text">
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                <select class="form-select custom-select" style="height:45px">
                                                    <option>Active</option>
                                                    <option>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer justify-content-start mt-3">
                                            <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                            &nbsp;  &nbsp;   &nbsp;
                                            <button type="submit" name="cancel" class="btn btn-primary">Reset</button>
                                        </div> 

                                    </div>
								</form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Hierarchy -->

                <!-- Add Hierarchy -->
                 <div id="add_hierarchy" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered " role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Hierarchy</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" action="{{ route('hierarchy.store')}}">
                                @csrf
                                <div class="row">
                                <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Hierarchy Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name">
                                                @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                    </div>
                                <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Level<span class="text-danger">*</span></label>
                                            <select name="level"  id="level" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="0">Level 1</option>
                                            <option value="1">Level 2</option>
                                            <option value="2">Level 3</option>
                                            <option value="3">Level 4</option>
                                            <option value="3">Level 5</option>
                                            <option value="3">Level 6</option>
                                            <option value="3">Level 7</option>
                                            </select>
                                            @error('level')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Value<span class="text-danger">*</span></label>
                                            <select id="value" name="value" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="IS">Immediate Supervisor</option>
                                            <option value="SH">Section Head</option>
                                            <option value="DH">Department Head</option>
                                            <option value="MM">Management</option>
                                            <option value="HR">Human Resource</option>
                                            <option value="FH">Finance Head</option>
                                            </select>
                                            @error('value')
                                                <small class="text-danger">{{ $message }}</small>
                                             @enderror

                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
										<label>Start Date <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text" name="start_date" id="start_date">
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
											<input class="form-control datetimepicker" type="text" id="end_date" name="end_date">
                                            @error('start_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                            @enderror
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                <select  id="status" name="status" class="form-select custom-select" style="height:45px">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('start_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-start mt-3">
                                            <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                            <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                                        </div>
								</form>

						</div>
					</div>
				</div>
                 <!-- Add Hierarchy -->
                  
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



