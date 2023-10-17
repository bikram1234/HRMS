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
                    <h3 class="page-title">Holiday</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Work Structure/Holiday</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holidaytype"><i class="fa fa-plus"></i> Add HolidayType</a>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Holiday</a>
                </div>
            </div>
        </div>

        
        <!-- /Page Header -->
 
        <!-- Search Filter -->
        <!-- <div class="row filter-row mt-3">
            <div class="col-sm-6 col-md-3"> 
                <div class="form-group form-focus select-focus">
                    <select class="select floating"> 
                        <option>-</option>
                        <option>2019</option>
                        <option>2018</option>
                        <option>2017</option>
                        <option>2016</option>
                        <option>2015</option>
                    </select>
                    <label class="focus-label">Select Year</label>
				</div>
			</div>
            <div class="col-sm-6 col-md-3">  
                <a href="#" class="btn btn-success btn-block w-100">Search</a>
            </div>     
        </div> -->
        <!-- /Search Filter -->
        <div class="row mt-3">
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
                                            <th>Holiday Name</th>
                                            <th>Holiday Type</th>
                                            <th>Region</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                            <tbody>
                                                @foreach($holidays as $key=> $holiday)
                                                <tr>
                                                <th style="width: 30px;">
                                                <label>
                                                    <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{ $key + 1 }}</span>
                                                    </label>
                                                    </th>
                                                    <td>{{ $holiday->name }}</td>
                                                    <td>{{ $holiday->holidayType->name }}</td>
                                                    <td>@foreach($holiday->regions as $region)
                                                        {{ $region->name }}
                                                        @if(!$loop->last)
                                                            , <!-- Add a comma if it's not the last region -->
                                                        @endif
                                                         @endforeach
                                                    </td>
                                                    <td>{{ $holiday->start_date }}</td>
                                                    <td>{{ $holiday->end_date }}</td>
                                                    <td class="text-right">
                                                        <div class="d-flex align-items-center">
                                                            <a href="" data-toggle="modal" data-target="#edit_holiday{{$holiday->id}}">
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
        <!-- /Edit Holiday -->
        <div id="edit_holiday{{$holiday->id}}" class="modal custom-modal fade" role="dialog">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Holiday</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               
                                    <div class="row">
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">HolidayType Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                        <div class="form-group">
                                        <label class="col-form-label">Holiday Type<span class="text-danger">*</span></label>
                                            <select id="year" name="year" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                    
                                                <?php
                                                // Get the current year
                                                $currentYear = date('Y');
                                                
                                                // Generate options for the current year and the next two years
                                                for ($i = 0; $i < 3; $i++) {
                                                    $year = $currentYear + $i;
                                                    echo "<option value=\"$year\">$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Holiday Type<span class="text-danger">*</span></label>
                                            <select id="holidaytype_id" name="holidaytype_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option selected disabled >Select Holiday</option>
                                                @foreach($holidaytypes as $holiday)
                                                    <option value="{{ $holiday->id }}">{{ $holiday->name }}</option>
                                                @endforeach
                                                <!-- Add more options as needed -->
                                            </select>
                                            @error('holidaytype_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Region<span class="text-danger">*</span></label>
                                            <select id="region_id" name="region_id[]" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            @foreach($regions as $region)
                                            <option value="{{ $region->id}}">{{ $region->name}}</option>
                                            @endforeach

                                            @error('region_id')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            </select>

                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                        <div class="form-group mt-2">
										<label> Start Date <span class="text-danger">*</span></label>
                                        <input class="form-check-input" type="radio" id="rdholidayfirsthalf" value="First Half" name="optradioholidayfrom">
                                        <label class="form-check-label" for="option1">
                                            First Half
                                        </label>
                                        <input class="form-check-input" type="radio"  id="rdholidaysecondhalft" name="optradioholidayfrom" value="Second Half">
                                        <label class="form-check-label" for="option2">
                                            Second Half
                                        </label>
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text" name="start_date">
										</div>
									</div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mt-2">
										<label> End Date <span class="text-danger">*</span></label>

                                        <input class="form-check-input" type="radio" id="rdholidayfirsthalft" name="optradioholidayfrom" value="firsthalf">
                                        <label class="form-check-label" for="option1">
                                            First Half
                                        </label>
                                        <input class="form-check-input" type="radio" id="rdholidaysecondhalft" name="optradioholidayfrom"  value="secondhalf">
                                        <label class="form-check-label" for="option2">
                                            Second Half
                                        </label>
                                       
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text" name="end_date">
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">No of Days<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="number_of_days" name="number_of_days">
                                                @error('number_of_days')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label"> Decription</label>
                                                <div class="form-floating">
                                                <textarea class="form-control" id="description" name="description"  style="height: 100px"></textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                               
                            </div>
                           
                        </div>
                        <div class="modal-footer justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                    </div>
                    </form>
                </div>
                <!-- /Edit Holiday-->
                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Holiday -->
        <div id="add_holiday" class="modal custom-modal fade" role="dialog">
            <form method="POST" action="{{ route('holiday.store')}}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Holiday</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row">
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">HolidayType Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                        <div class="form-group">
                                        <label class="col-form-label">Holiday Type<span class="text-danger">*</span></label>
                                            <select id="year" name="year" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                    
                                                <?php
                                                // Get the current year
                                                $currentYear = date('Y');
                                                
                                                // Generate options for the current year and the next two years
                                                for ($i = 0; $i < 3; $i++) {
                                                    $year = $currentYear + $i;
                                                    echo "<option value=\"$year\">$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Holiday Type<span class="text-danger">*</span></label>
                                            <select id="holidaytype_id" name="holidaytype_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option selected disabled >Select Holiday</option>
                                                @foreach($holidaytypes as $holiday)
                                                    <option value="{{ $holiday->id }}">{{ $holiday->name }}</option>
                                                @endforeach
                                                <!-- Add more options as needed -->
                                            </select>
                                            @error('holidaytype_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Region<span class="text-danger">*</span></label>
                                            <select id="region_id" name="region_id[]" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            @foreach($regions as $region)
                                            <option value="{{ $region->id}}">{{ $region->name}}</option>
                                            @endforeach

                                            @error('region_id')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            </select>

                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                        <div class="form-group mt-2">
										<label> Start Date <span class="text-danger">*</span></label>
                                        <label class="radio-inline" >
                                        <input class="fromcheck" type="radio"  id="rdholidayfirsthalft" value="First Half" name="optradioholidayfrom">
                                            First Half
                                        </label>
                                        <label class="radio-inline" >
                                        <input class="fromcheck" type="radio"  id="rdholidaysecondhalft"  value="Second Half" name="optradioholidayfrom">
                                            Second Half
                                        </label>
                                        @error('optradioholidayfrom')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text" id="txt_istartdate" name="start_date"  required>
										</div>
                                       
									</div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mt-2">
										<label> End Date <span class="text-danger">*</span></label>
                                        <label class="radio-inline" >
                                        <input class="fromcheck" type="radio" id="rdholidayfirsthalftto"  name="optradioholidaylto" value="First Half">
                                            First Half
                                        </label>

                                        <label class="radio-inline" >
                                        <input class="fromcheck" type="radio" id="rdholidaysecondhalftto"  name="optradioholidaylto"  value="Second Half">
                                            Second Half
                                        </label>
                                       
										<div class="cal-icon">
											<input class="form-control datetimepicker " type="text" name="end_date"  id="txt_ienddate">
										</div>

									</div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">No of Days<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="number_of_days" name="number_of_days">
                                                @error('number_of_days')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label"> Decription</label>
                                                <div class="form-floating">
                                                <textarea class="form-control" id="description" name="description"  style="height: 100px"></textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                            </div>
                           
                        </div>
                        <div class="modal-footer justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- /Add Holiday-->
</div>
</div>

 

                <!-- /Add HolidayType -->
                <div id="add_holidaytype" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add HolidayType</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('holidaytype.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">HolidayType Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="name" name="name" required>
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
                                     <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add HolidayType-->

               

                   <!-- Edit Holiday -->
                   <div id="edit_holiday" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Holiday</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Holiday Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" value="Holiday Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Year<span class="text-danger">*</span></label>
                                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="0">2023</option>
                                            <option value="1">2022</option>
                                            <option value="2">2021</option>
                                            <option value="3">2019</option>
                                            <option value="3">2018</option>
                                            <option value="3">2017</option>
                                            <option value="3">2016</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Holiday Type<span class="text-danger">*</span></label>
                                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="0">Public </option>
                                            <option value="1">Government</option>
                                            <option value="2">Restricted</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Region<span class="text-danger">*</span></label>
                                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="0">Bumthang</option>
                                            <option value="1">Gelephu</option>
                                            <option value="2">Paro</option>
                                            </select>

                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                        <div class="form-group mt-2">
										<label> Start Date <span class="text-danger">*</span></label>

                                        <input class="form-check-input" type="radio" name="option" id="option1" value="option1">
                                        <label class="form-check-label" for="option1">
                                            First Half
                                        </label>
                                        <input class="form-check-input" type="radio" name="option" id="option2" value="option2">
                                        <label class="form-check-label" for="option2">
                                            Second Half
                                        </label>
                                        
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text">
										</div>
									</div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mt-2">
										<label> End Date <span class="text-danger">*</span></label>

                                        <input class="form-check-input" type="radio" name="option" id="option1" value="option1">
                                        <label class="form-check-label" for="option1">
                                            First Half
                                        </label>
                                        <input class="form-check-input" type="radio" name="option" id="option2" value="option2">
                                        <label class="form-check-label" for="option2">
                                            Second Half
                                        </label>
                                       
										<div class="cal-icon">
											<input class="form-control datetimepicker" type="text">
										</div>
									</div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">No of Days<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" value="Holiday Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label"> Decription</label>
                                                <div class="form-floating">
                                                <textarea class="form-control" placeholder="This textarea has a limit of 500 characters" id="floatingTextarea2" style="height: 100px"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Submit</button>
                                        <button class="btn btn-light cancel-btn" >Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Holiday-->

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

<script>
    $(document).ready(function () {
        // Function to update the number of days and disable radio buttons
        function updateNumberOfDays() {
            const startDate = $('#txt_istartdate').val();
            const endDate = $('#txt_ienddate').val();
            const dayTypeStart = $("input[name='optradioholidayfrom']:checked").val();
            const dayTypeEnd = $("input[name='optradioholidaylto']:checked").val();

            let numberOfDays = 0;

            // If "First Half" is selected for "Start Date"
            if (dayTypeStart === "First Half") {
                numberOfDays = 0.5;
                // Set the "To Date" to be the same as "From Date"
                $('#txt_ienddate').val(startDate);
                // Disable both radio buttons for "End Date"
                $('#rdholidayfirsthalftto').prop('disabled', true);
                $('#rdholidaysecondhalftto').prop('disabled', true);
            } else if (dayTypeStart === "Second Half") {
                // If "Second Half" is selected for "Start Date", calculate the number of days based on the date range
                numberOfDays = calculateNumberOfDays(startDate, endDate) - 0.5;

                // Disable "Second Half" radio button for "End Date"
                $('#rdholidaysecondhalftto').prop('disabled', true);

                // Enable "First Half" radio button for "End Date"
                $('#rdholidayfirsthalftto').prop('disabled', false);
            } else {
                // Enable both radio buttons for "End Date"
                $('#rdholidayfirsthalftto').prop('disabled', false);
                $('#rdholidaysecondhalftto').prop('disabled', false);
            }

            // If "First Half" is selected for "End Date"
            if (dayTypeEnd === "First Half") {
                // Check if the second half in the "From Date" is selected
                if (dayTypeStart !== "Second Half") {
                    numberOfDays = calculateNumberOfDays(startDate, endDate) - 0.5;
                } else {
                    numberOfDays = calculateNumberOfDays(startDate, endDate) - 1;  
                }
            } else if (!dayTypeStart && !dayTypeEnd) {
                // Calculate the number of days as a whole day
                numberOfDays = calculateNumberOfDays(startDate, endDate);
            }

            $('#number_of_days').val(numberOfDays);
        }

        // Function to calculate the number of days between two dates
        function calculateNumberOfDays(startDate, endDate) {
            const oneDay = 24 * 60 * 60 * 1000; // One day in milliseconds
            const startTimestamp = new Date(startDate).getTime();
            const endTimestamp = new Date(endDate).getTime();
            const diffDays = Math.round(Math.abs((startTimestamp - endTimestamp) / oneDay)) + 1;
            return diffDays;
        }

        // Attach event listeners to date input elements for real-time updates
        $('#txt_istartdate, #txt_ienddate').change(updateNumberOfDays);

        // Attach event listener to radio buttons for real-time updates
        $('input[type=radio]').change(updateNumberOfDays);

        // Initial calculation when the page loads
        updateNumberOfDays();

        // Attach event listener to radio buttons for "From Date" for resetting
        $('input[name="optradioholidayfrom"]').change(function () {
            const dayTypeStart = $("input[name='optradioholidayfrom']:checked").val();

            // Check if "First Half" in "From Date" is selected
            if (dayTypeStart === "First Half") {
                // Set the "To Date" to be the same as "From Date"
                $('#txt_ienddate').val($('#txt_istartdate').val());
                // Disable both radio buttons for "To Date"
                $('#rdholidayfirsthalftto').prop('disabled', true);
                $('#rdholidaysecondhalftto').prop('disabled', true);

                // Reset the form elements
                resetForm();

                // Set the number of days to 0.5
                $('#number_of_days').val('0.5');
                $("input[name='optradioholidaylto']").prop('checked', false);

            } else {
                // Handle other cases here, if needed
            }
        });

        // Function to reset the form elements
        function resetForm() {
            // Clear other form elements or perform additional reset actions if necessary
            // Reset the number of days to 0.5
            $('#number_of_days').val('0.5');
        }
    });


</script>
<script>
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'DD-MM-YYYY', // Set the desired date format
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



