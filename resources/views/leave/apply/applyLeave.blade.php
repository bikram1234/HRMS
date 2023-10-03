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