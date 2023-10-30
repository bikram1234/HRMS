@extends('layout')  <!-- Extend your layout file -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Apply for Leave</div>
                <div class="card-body">
                <form method="POST" action="{{ route('applyleave.store') }}">
                    @csrf
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" id="user_id" name="user_id" class="form-control" value="{{ auth()->user()->id }}" required readonly>
                        </div>  

                        <div class="form-group">
                            <label for="leave_type">Leave Type</label>
                            <select id="leave_type_select" name="leave_type" class="form-control">
                                <!-- Populate this dropdown with available leave types -->
                                @foreach($leave_types as $leave)
                                <option value="{{ $leave->id }}">{{ $leave->name }}</option>
                                @endforeach
                                <!-- Add more options as needed -->
                                @error('leave_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="leave_balance">Leave Balance</label>
                            <input type="text" id="leave_balance" name="leave_balance" class="form-control" readonly required>
                        </div>
                        
                    <div class="form-group mt-3">
                        <select id="day_type_start" name="day_type_start" class="form-control" required>
                            <option value="full_day">Full Day</option>
                            <option value="before_half">Before Half</option>
                            <option value="after_half">After Half</option>
                            <option value="shift">Shift</option>
                        </select>
                        <label for="start_date">From Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                        @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <select id="day_type_end" name="day_type_end" class="form-control" required>
                            <option value="full_day">Full Day</option>
                            <option value="before_half">Before Half</option>
                            <option value="after_half">After Half</option>
                            <option value="shift">Shift</option>
                        </select>
                        <label for="end_date">To Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                        @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="number_of_days">No. of Days</label>
                        <input type="number" id="number_of_days" name="number_of_days" class="form-control" required readonly>
                        @error('number_of_days')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea id="remark" name="remark" class="form-control" rows="3"></textarea>
                            @error('remark')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="file_path">Attach File</label>
                            <input type="file" id="file_path" name="file_path" class="form-control-file">
                            @error('file_path')
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

</div>
@endsection


<div class="form-group mt-3">
    <select id="day_type_start" name="day_type_start" class="form-control" required>
        <option value="full_day">Full Day</option>
        <option value="before_half">Before Half</option>
        <option value="after_half">After Half</option>
        <option value="shift">Shift</option>
    </select>
    <label for="start_date">From Date</label>
    <input type="date" id="start_date" name="start_date" class="form-control" required>
    @error('start_date')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group mt-3">
    <select id="day_type_end" name="day_type_end" class="form-control" required>
        <option value="full_day">Full Day</option>
        <option value="before_half">Before Half</option>
        <option value="after_half">After Half</option>
        <option value="shift">Shift</option>
    </select>
    <label for="end_date">To Date</label>
    <input type="date" id="end_date" name="end_date" class="form-control" required>
    @error('end_date')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="number_of_days">No. of Days</label>
    <input type="number" id="number_of_days" name="number_of_days" class="form-control" required readonly>
    @error('number_of_days')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Add an event listener for day type and date fields
        $('#day_type_start, #day_type_end, #start_date, #end_date').on('change', function () {
            updateNumberOfDays();
        });

        function updateNumberOfDays() {
            const dayTypeStart = $('#day_type_start').val();
            const dayTypeEnd = $('#day_type_end').val();
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());
            let numberOfDays = 0.0;

            while (startDate <= endDate) {
                // Skip weekends (Saturday and Sunday)
                if (startDate.getDay() !== 0 && startDate.getDay() !== 6) {
                    switch (dayTypeStart) {
                        case 'full_day':
                            numberOfDays += 1;
                            break;
                        case 'before_half':
                            numberOfDays += 0.5;
                            break;
                        case 'after_half':
                            numberOfDays += 0.5;
                            break;
                        case 'shift':
                            // Implement logic for 'shift' if needed
                            break;
                    }
                }

                if (startDate.getTime() === endDate.getTime()) {
                    break; // Exit loop if the start and end dates are the same
                }

                startDate.setDate(startDate.getDate() + 1);
            }

            if (dayTypeEnd !== 'full_day') {
                // If the end day type is not full day, add 0.5 for the end day
                numberOfDays += 0.5;
            }

            $('#number_of_days').val(numberOfDays);
        }

        // Initial calculation when the page loads
        updateNumberOfDays();
    });
</script>



<script>
    // Get references to the leave type and leave balance elements
    var leaveTypeSelect = document.getElementById('leave_type_select');

    // Add an event listener to the leave type dropdown
    leaveTypeSelect.addEventListener('change', function() {
        var selectedLeaveTypeId = this.value;

        // Clear the existing leave balance
        leaveBalanceInput.value = '';

        // Make an AJAX request to fetch the leave balance
        fetch('/fetch-include-weekends/' + selectedLeaveTypeId)
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



<!-- Working js code for include weekends -->

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

        // Function to calculate the number of days
        function calculateNumberOfDays(startDate, endDate, dayTypeStart, dayTypeEnd, includeWeekends) {
            let numberOfDays = 0.0;
            const millisecondsPerDay = 24 * 60 * 60 * 1000;

            while (startDate <= endDate) {
                const isSunday = startDate.getDay() === 0;
                const isSaturday = startDate.getDay() === 6;

                if (includeWeekends || (!isSunday && !isSaturday)) {
                    if (startDate.toDateString() === endDate.toDateString()) {
                        if (dayTypeStart === 'first_half' || dayTypeStart === 'second_half') {
                            numberOfDays += 0.5;
                        } else {
                            numberOfDays += 1;
                        }
                    } else {
                        numberOfDays += 1;
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
        function updateNumberOfDays(includeWeekends) {
            const dayTypeStart = $('#day_type_start').val();
            const dayTypeEnd = $('#day_type_end').val();
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());

            const numberOfDays = calculateNumberOfDays(startDate, endDate, dayTypeStart, dayTypeEnd, includeWeekends);
            $('#number_of_days').val(numberOfDays);
        }

        // Add event listeners for day type, date fields, and leave type
        $('#day_type_start, #day_type_end, #start_date, #end_date, #leave_type_select').on('change', function () {
            const selectedLeaveTypeId = $('#leave_type_select').val();

            // Fetch the include_weekends setting for the selected leave type
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (includeWeekends) {
                    // Calculate the number of days and update the UI
                    updateNumberOfDays(includeWeekends);
                });
        });

        // Initial calculation when the page loads
        updateNumberOfDays(false); // Default to exclude weekends

        // Additional event listeners for start_date and end_date
        $('#start_date, #end_date').on('change', function () {
            // Calculate the number of days when start_date or end_date changes
            const selectedLeaveTypeId = $('#leave_type_select').val();
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (includeWeekends) {
                    updateNumberOfDays(includeWeekends);
                });
        });
    });
</script>


<!-- <script>
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
                        throw an Error('Network response was not ok');
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

</script> -->

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
                        throw an Error('Network response was not ok');
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
                    return data;
                })
                .catch(function (error) {
                    console.error('Error fetching include_weekends:', error);
                    return { include_weekends: false, can_be_half_day: false };
                });
        }

        // Function to fetch the include_public_holidays setting for the selected leave type
        function fetchIncludePublicHolidays(selectedLeaveTypeId) {
            return fetch('/fetch-include-public-holidays/' + selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw an Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data;
                })
                .catch(function (error) {
                    console.error('Error fetching include_public_holidays:', error);
                    return false;
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

        // Function to calculate the number of days
        function calculateNumberOfDays(startDate, endDate, dayTypeStart, dayTypeEnd, includeWeekends, includePublicHolidays, holidayDates) {
            // ... (rest of the calculateNumberOfDays function as in your previous code)

            return numberOfDays;
        }

        // Function to enable or disable "First Half" and "Second Half" options
        function toggleHalfDayOptions(canBeHalfDay) {
            const $halfDayOptions = $('#day_type_start option[value="first_half"], #day_type_start option[value="second_half"], #day_type_end option[value="first_half"], #day_type_end option[value="second_half"]');

            if (canBeHalfDay) {
                $halfDayOptions.prop('disabled', false);
            } else {
                $halfDayOptions.prop('disabled', true);
            }
        }

        // Function to update the number of days and set it in the UI
        function updateNumberOfDays(includeWeekends, includePublicHolidays) {
                const dayTypeStart = $('#day_type_start').val();
                const dayTypeEnd = $('#day_type_end').val();
                const startDate = new Date($('#start_date').val());
                const endDate = new Date($('#end_date').val());

                // Fetch the list of holiday dates
                fetchHolidayDates()
                    .then(function (holidayDates) {
                        console.log('dates', holidayDates);
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

            // Fetch the include_weekends and can_be_half_day settings for the selected leave type
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (data) {
                    const includeWeekends = data.include_weekends;
                    const canBeHalfDay = data.can_be_half_day;

                    // Fetch the include_public_holidays setting for the selected leave type
                    fetchIncludePublicHolidays(selectedLeaveTypeId)
                        .then(function (includePublicHolidays) {
                            // Calculate the number of days and update the UI
                            updateNumberOfDays(includeWeekends, includePublicHolidays);
                            // Toggle "First Half" and "Second Half" options
                            toggleHalfDayOptions(canBeHalfDay);
                        });
                });
        });

        // Initial calculation when the page loads
        updateNumberOfDays(false, false); // Default to exclude weekends and public holidays
        toggleHalfDayOptions(false); // Default to disable "First Half" and "Second Half" options

        // Additional event listeners for start_date and end_date
        $('#start_date, #end_date').on('change', function () {
            // Calculate the number of days when start_date or end_date changes
            const selectedLeaveTypeId = $('#leave_type_select').val();
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (data) {
                    const includeWeekends = data.include_weekends;
                    const canBeHalfDay = data.can_be_half_day;

                    fetchIncludePublicHolidays(selectedLeaveTypeId)
                        .then(function (includePublicHolidays) {
                            updateNumberOfDays(includeWeekends, includePublicHolidays);
                        });
                });
        });
    });

</script>