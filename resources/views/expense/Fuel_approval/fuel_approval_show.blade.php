{{-- {{-- @extends('layout') <!-- Extend your layout file -->

@section('content')
<div class="container">
    <h1>Pending and Approved Expense Applications</h1>

    <form action="{{ route('fuel.approval.index') }}" method="GET">
        <div class="form-group">
            <label for="statusFilter">Filter by Status:</label>
            <select class="form-control" name="status" id="statusFilter">
                <option value="">All</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAll"> <!-- Add Select All checkbox -->
                </th>
                <th>Employee</th>
                <th>Date</th>
                <th>Location</th>
                <th>Vehicle Type</th>
                <th>Mileage</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fuel_approval as $fuel)
            <tr>
                <td>
                    <input type="checkbox" class="selectSingle" name="selected[]" value="{{ $fuel->id }}">
                </td>
                <td>{{ $fuel->employee_name }}</td>
                <td>{{ $fuel->date }}</td>
                <td>{{ $fuel->location }}</td>
                <td>{{ $fuel->vehicle_type }}</td>
                <td>{{ $fuel->mileage }}</td>
                <td>{{ $fuel->amount }}</td>
                <td>{{ $fuel->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <button class="btn btn-success" id="approveButton">Approve</button>
        <button class="btn btn-danger" id="rejectButton">Reject</button>
    </div>
</div>

<script>
    // Add JavaScript to handle "Select All" functionality
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.selectSingle');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection --}}

@extends('layout') <!-- Extend your layout file -->

@section('content')
<div class="container">
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

    <form action="{{ route('fuel.approval.index') }}" method="GET">
        <div class="form-group">
            <label for="statusFilter">Filter by Status:</label>
            <select class="form-control" name="status" id="statusFilter">
                <option value="">All</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAll"> <!-- Add Select All checkbox -->
                </th>
                <th>Employee</th>
                <th>Date</th>
                <th>Location</th>
                <th>Vehicle Type</th>
                <th>Mileage</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenseApplications as $expenseApplication)
                <tr>
                    <td>
                        <input type="checkbox" class="selectSingle" name="selected[]" value="{{ $expenseApplication->id }}">
                    </td>
                    <td>{{ $expenseApplication->employee_name }}</td>
                    <td>{{ $expenseApplication->date }}</td>
                    <td>{{ $expenseApplication->location }}</td>
                    <td>{{ $expenseApplication->vehicle_type }}</td>
                    <td>{{ $expenseApplication->mileage }}</td>
                    <td>{{ $expenseApplication->amount }}</td>
                    <td>{{ $expenseApplication->status }}</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptleave{{ $expenseApplication->id }}">Approve</a>
                        <a type="button"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#declineleave{{ $expenseApplication->id}}">Reject</a> 
                        <a href="{{ route('fuel.view', ['id' => $expenseApplication->id]) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
                <div class="modal" id="acceptleave{{ $expenseApplication->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Approval</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form method="POST" action="{{ route('fuel.approve', ['id' => $expenseApplication->id]) }}">
                                    @csrf
                                    <h4>Are you sure you want to approve this leave?</h4>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Approve Now</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="declineleave{{ $expenseApplication->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Decline</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form method="POST" action="{{ route('fuel.reject', ['id' => $expenseApplication->id]) }}">
                                    @csrf
                                    <h4>Are you sure you want to reject this expense?</h4>
                                    <div class="form-group">
                                        <label for="remark">Remark:</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
                                    </div>
                
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Reject Now</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Add JavaScript to handle "Select All" functionality
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.selectSingle');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection 
