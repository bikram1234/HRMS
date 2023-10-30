@extends('layout')

@section('content')
   <div class="container mt-5">
        
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
        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModalholidaytype">
             Add HolidayType
        </button>

        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModalholiday">
             Add Holiday
        </button>

<div class="modal" id="myModalholidaytype">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Holiday Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('holidaytype.store') }}" enctype="multipart/form-data">
                        @csrf 

                            <div class="form-group">
                                <label for="name">HolidayType Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option disabled selected>Choose status:</option>
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

<div class="modal" id="myModalholiday">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Holiday</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('holiday.store') }}" enctype="multipart/form-data">
                        @csrf 

                            <div class="form-group">
                                <label for="name">HolidayType Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <select name="year" id="">
                                    <option disabled selected>Year</option>
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


                            <div class="form-group">
                                            <label for="holidaytype_id">Holiday</label>
                                            <select id="holidaytype_id" name="holidaytype_id" class="form-control">
                                                <!-- Populate this dropdown with available countries -->
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

                                <select id="region_id" name="region_id[]" class="form-control" multiple="multiple">
                                    <!-- Populate this dropdown with available countries -->
                                    <option selected disabled>Select Region</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                    <!-- Add more options as needed -->
                                    @error('region_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                </select>

                                <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline">
                                                <input type="radio" id="rdholidayfirsthalft" class="fromcheck" value="First Half" name="optradioholidayfrom">First Half
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="rdholidaysecondhalft" class="fromcheck" value="Second Half" name="optradioholidayfrom">Second Half
                                            </label>
                                            @error('optradioholidayfrom')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="cal-icon">
                                            <input class="form-control" id="txt_istartdate" type="date" name="start_date" placeholder="dd-mmm-yyyy" style="background-color: rgb(255, 255, 255);" required>
                                        </div>
                                        @error('start_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <div class="radio">
                                            <label class="radio-inline">
                                                <input type="radio" id="rdholidayfirsthalftto" class="fromcheck" value="First Half" name="optradioholidaylto">First Half
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="rdholidaysecondhalftto" class="fromcheck" value="Second Half" name="optradioholidaylto">Second Half
                                            </label>
                                        </div>
                                        <div class="cal-icon"><input class="form-control" id="txt_ienddate" placeholder="dd-mmm-yyyy" type="date" name="end_date"></div>
                                    </div>


                                    <div class="form-group">
                                        <label>No of Days:</label>
                                        <input class="form-control" id="number_of_days" name="number_of_days" readonly="" type="text">
                                        @error('number_of_days')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">description</label>
                                        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                                        @error('description')
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


        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Holiday Name</th>
                    <th>Holiday Type</th>
                    <th>Region</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($holidays->count() > 0)
                @foreach($holidays as $holiday)
                    <tr>
                        <td>1</td>
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
                        <td>
                            <a data-toggle="modal" data-target="#myModal{{$holiday->id}}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave type?')">Delete</button>
                            </form>
                        </td>

                        <div class="modal" id="myModal{{$holiday->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">holiday Edit</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                    
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form method="POST" action="" enctype="multipart/form-data">
                                                @csrf 
                                                    @method('patch')
                                                    <div class="form-group">
                                                        <label for="code">Code</label>
                                                        <input type="text" id="code" name="code" class="form-control" value="{{ $holiday->code }}" required>
                                                        @error('code')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">holiday Name</label>
                                                        <input type="text" id="name" name="name" class="form-control" value="{{ $holiday->name }}" required>
                                                        @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="{{ $holiday->status }}">Choose status:</option>
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
                    </tr>
                @endforeach
                @else
                <h1>No datas</h1>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
    $(document).ready(function() {
        $('#region_id').multiselect({
            includeSelectAllOption: true // Add a "Select All" option
        });
    });
</script>

    <script>
        // Auto-hide the success message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>
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




@endsection