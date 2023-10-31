
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
                    <h3 class="page-title">Apply Leave</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Leave Management/Apply Leave</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#apply_leave"><i class="fa fa-plus"></i> Apply Leave</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 mb-3">  
                <a href="#" class="btn btn-primary btn-block w-100" data-toggle="modal" data-target="#edit_type">Leave Encashment</a>
            </div>  
            <div class="col-sm-6 col-md-3 mb-3">  
                <a href="#" class="btn btn-primary btn-block w-100">Leave Balance</a>
            </div>    
        </div>
        <!-- /Search Filter -->
                
                
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
                                        <th>Leave Type</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>No.of.Days</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                     </tr>
                            </thead>
                            <tbody>
                           
                                 @foreach($leaveHistory as $key => $history)
                                    <tr>
                                    <th style="width: 30px;">
                                    <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        <span>{{ $key + 1 }}</span>
                                        </label>
                                        </th>
                                        <td>{{ $history->employee->name }}</td>
                                        <td>{{ $history->leavetype->name }}</td>
                                        <td>{{ $history->start_date }}</td>
                                        <td>{{ $history->end_date }}</td>
                                        <td>{{ $history->number_of_days }}</td>
                                        <td>
                                            @if ($history->status === 'pending')
                                                <button class="btn btn-warning">Pending</button>
                                            @elseif ($history->status === 'approved')
                                                <button class="btn btn-success">Approved</button>
                                            @elseif ($history->status === 'rejected')
                                                <button class="btn btn-danger">Rejected</button>
                                            @endif
                                        </td>
                                            <td class="text-right">
                                            <div class="d-flex align-items-center">
                                        
                                            <a href="" data-toggle="modal" data-target="">
                                                <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                            </a>
                                            <span class="icon-spacing"></span>
                                            <a href="{{ route('leavePolicy.view', ['leave_id' => $history->leave_id])}}">  <i class="bi bi-eye-fill h3"></i></a> 
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


                <!-- /Apply Leave -->
            <div id="apply_leave" class="modal custom-modal fade" role="dialog">
                <form method="POST" action="{{ route('applyleave.store')}}">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Apply Leave</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="user_id">Employee<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="user_id" name="user_id" value="{{ auth()->user()->id }}" required readonly>
                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Leave Type<span class="text-danger">*</span></label>
                                            <select  id="leave_type_select" name="leave_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option selected disabled>Select LeaveType</option>
                                            @foreach($leave_types as $leave)
                                            <option value="{{ $leave->id }}">{{ $leave->name }}</option>
                                            @endforeach
                                            </select>
                                            @error('leave_type')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Leave Balance<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="leave_balance" name="leave_balance" readonly required>
                                            </div>
                                        </div>
                                    
                      
                                        <div class="col-sm-12">
                                        <div class="form-group mt-2">
                                        <select id="day_type_start" name="day_type_start"class="form-select  form-select-md" aria-label="Default select example" style="height:45px" required>
                                            <option value="full_daye">Full Day</option>
                                            <option value="before_half">Before Half Day</option>
                                            <option value="after_half">After Half Day</option>
                                            <option value="shift">Shift</option>
                                        </select>
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" >
                                            @error('start_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group mt-2">
                                        <select id="day_type_end" name="day_type_end" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option value="full_faye">Full Day</option>
                                            <option value="before_half">First Half Day</option>
                                            <option value="after_half">Second Half Day</option>
                                            <option value="shift">Shift</option>
                                        </select>
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control" >
                                            @error('end_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">No of Days<span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" id="number_of_days" name="number_of_days" required readonly>
                                                @error('number_of_days')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label"> Remarks</label>
                                                <div class="form-floating">
                                                <textarea class="form-control" id="remark" name="remark" style="height: 100px"></textarea>
                                                @error('remark')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label  class="col-form-label">Attachments<span class="text-danger">Max Size(MB)</span></label>
                                                <input class="form-control" type="file" id="file_path" name="file_path">
                                            </div>
                                            @error('file_path')
                                                    <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>                               
                                     </div>
                                </div>
                            <div class="modal-footer justify-content-start">
                                <button type="submit" name="save" class="btn btn-primary">Apply Leave</button>
                                <button  name="cancel" class="btn btn-secondary">Cancel</button>
                            </div>
                    </div>
                    </form>
                </div>
                <!-- /Apply Leave-->         
                
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

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
    // Get references to the leave type and leave balance elements
    var leaveTypeSelect = document.getElementById('leave_type_select');
    var leaveBalanceInput = document.getElementById('leave_balance');

    // Add an event listener to the leave type dropdown
    leaveTypeSelect.addEventListener('change', function() {
        var selectedLeaveTypeId = this.value;

        // Clear the existing leave balance
        leaveBalanceInput.value = '';

        // Make an AJAX request to fetch the leave balance
        fetch('/fetch-leave-balance/' + selectedLeaveTypeId)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                var leaveBalance = data.balance;


                // Update the leave balance input with the fetched value
                leaveBalanceInput.value = leaveBalance;
            })
            .catch(function(error) {
                console.error('Error fetching leave balance:', error);
            });
    });

</script>

 <script>
    $(document).ready(function () {
        // Function to fetch the include_weekends setting for the selected leave type
        function fetchIncludeWeekends(selectedLeaveTypeId) {
            return fetch('/fetch-include-weekends/' + selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.include_weekends;
                })
                .catch(function (error) {
                    console.error('Error fetching include_weekends:', error);
                    return false; // Default to false if there's an error
                });
        }

        // Function to fetch the include_public_holidays setting for the selected leave type
        function fetchIncludePublicHolidays(selectedLeaveTypeId) {
            return fetch('/fetch-include-public-holidays/' + selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.include_public_holidays;
                })
                .catch(function (error) {
                    console.error('Error fetching include_public_holidays:', error);
                    return false; // Default to false if there's an error
                });
        }

        // Function to fetch the list of holiday dates
        function fetchHolidayDates() {
            return fetch('/fetch-holiday-dates')
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.holiday_dates;
                })
                .catch(function (error) {
                    console.error('Error fetching holiday dates:', error);
                    return [];
                });
        }

         // Function to fetch the can be half day or not
        function fetchCanbeHalfDay(selectedLeaveTypeId) {
            return fetch('/fetch-can-be-half-day/'+ selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.can_be_half_day;
                })
                .catch(function (error) {
                    console.error('Error fetching can_be_half_day data:', error);
                    return false; // Default to false if there's an error
                });
        }

        // Function to enable or disable "First Half" and "Second Half" options
        function toggleHalfDayOptions(canBeHalfDay) {
            const $halfDayOptions = $('#day_type_start option[value="first_half"], #day_type_start option[value="second_half"], #day_type_end option[value="first_half"], #day_type_end option[value="second_half"]');

            if (canBeHalfDay) {
                $halfDayOptions.prop('disabled', false);
            } else {
                $halfDayOptions.prop('disabled', true);
                // If "First Half" or "Second Half" was selected, switch to "Full Day"
                if ($('#day_type_start').val() === 'first_half' || $('#day_type_start').val() === 'second_half') {
                    $('#day_type_start').val('full_day');
                }
                if ($('#day_type_end').val() === 'first_half' || $('#day_type_end').val() === 'second_half') {
                    $('#day_type_end').val('full_day');
                }
            }
        }

        // Add event listener for the leave type select
        $('#leave_type_select').on('change', function () {
            const selectedLeaveTypeId = $('#leave_type_select').val();

            // Fetch the can_be_half_day setting for the selected leave type
            fetchCanbeHalfDay(selectedLeaveTypeId)
                .then(function (canBeHalfDay) {
                    // Toggle "First Half" and "Second Half" options based on can_be_half_day
                    toggleHalfDayOptions(canBeHalfDay);
                });
        });


       // Function to calculate the number of days
        function calculateNumberOfDays(startDate, endDate, dayTypeStart, dayTypeEnd, includeWeekends, includePublicHolidays, holidayDates) {
            let numberOfDays = 0.0;
            const millisecondsPerDay = 24 * 60 * 60 * 1000;

            while (startDate <= endDate) {
                const isSunday = startDate.getDay() === 0;
                const isSaturday = startDate.getDay() === 6;
                const isHoliday = holidayDates.includes(startDate.toISOString().split('T')[0]);

                if (includeWeekends || (!isSunday && !isSaturday)) {
                    if (includePublicHolidays || !isHoliday) {
                        if (startDate.toDateString() === endDate.toDateString()) {
                            if (dayTypeStart === 'first_half' || dayTypeStart === 'second_half') {
                                numberOfDays += 0.5;
                            } else {
                                numberOfDays += 1;
                            }
                        } else {
                            numberOfDays += 1;
                        }
                    }
                } else if (!includeWeekends && isSaturday) {
                    numberOfDays += 0.5; // Add 0.5 for Saturdays when weekends are not included
                }

                startDate.setTime(startDate.getTime() + millisecondsPerDay);
            }

            if ((dayTypeEnd === 'first_half' || dayTypeEnd === 'second_half') && numberOfDays > 0) {
                numberOfDays -= 0.5;
            }

            return numberOfDays;
        }


        // Update the number of days and set it in the UI
        function updateNumberOfDays(includeWeekends, includePublicHolidays) {
            const dayTypeStart = $('#day_type_start').val();
            const dayTypeEnd = $('#day_type_end').val();
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());

            // Fetch the list of holiday dates
            fetchHolidayDates()
                .then(function (holidayDates) {

                    const numberOfDays = calculateNumberOfDays(
                        startDate,
                        endDate,
                        dayTypeStart,
                        dayTypeEnd,
                        includeWeekends,
                        includePublicHolidays,
                        holidayDates
                    );
                    $('#number_of_days').val(numberOfDays);
                });
        }

        // Add event listeners for day type, date fields, and leave type
        $('#day_type_start, #day_type_end, #start_date, #end_date, #leave_type_select').on('change', function () {
            const selectedLeaveTypeId = $('#leave_type_select').val();

            // Fetch the include_weekends setting for the selected leave type
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (includeWeekends) {
                    // Fetch the include_public_holidays setting for the selected leave type
                    fetchIncludePublicHolidays(selectedLeaveTypeId)
                        .then(function (includePublicHolidays) {
                            // Calculate the number of days and update the UI
                            updateNumberOfDays(includeWeekends, includePublicHolidays);
                        });
                });
        });

        // Initial calculation when the page loads
        updateNumberOfDays(false, false); // Default to exclude weekends and public holidays

        // Additional event listeners for start_date and end_date
        $('#start_date, #end_date').on('change', function () {
            // Calculate the number of days when start_date or end_date changes
            const selectedLeaveTypeId = $('#leave_type_select').val();
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (includeWeekends) {
                    fetchIncludePublicHolidays(selectedLeaveTypeId)
                        .then(function (includePublicHolidays) {
                            updateNumberOfDays(includeWeekends, includePublicHolidays);
                        });
                });
        });
    });

</script> 

@endsection



