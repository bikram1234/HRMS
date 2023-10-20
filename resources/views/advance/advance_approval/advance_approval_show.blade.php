{{-- @extends('layout') <!-- Extend your layout file -->

@section('content')
<div class="container">
    <h1>Pending and Approved Expense Applications</h1>

    <form action="{{ route('advance.approval.index') }}" method="GET">
        <div class="form-group">
            <label for="statusFilter">Filter by Status:</label>
            <select class="form-control" name="status" id="statusFilter">
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
                <th>Advance Date</th>
                <th>Advance Type</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($advances as $advances)
            <tr>
                <td>
                    <input type="checkbox" class="selectSingle" name="selected[]" value="{{ $advances->id }}">
                </td>
                <td>{{ $advances->user->name }}</td>
                <td>{{ $advances->date }}</td>
                <td>{{ $advances->advanceType->name }}</td>
                <td>{{ $advances->amount }}</td>
                <td>{{ $advances->status }}</td>
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

     <form action="{{ route('advance.approval.index') }}" method="GET"> 
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
                <th>Advance Date</th>
                <th>Advance Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($advanceApplications as $advanceApplication)
                <tr>
                    <td>
                        <input type="checkbox" class="selectSingle" name="selected[]" value="{{ $advanceApplication->id }}">
                    </td>
                    <td>{{ $advanceApplication->user->name }}</td>
                    <td>{{ $advanceApplication->date }}</td>
                    <td>{{ $advanceApplication->advanceType->name }}</td>
                    <td>{{ $advanceApplication->amount }}</td>
                    <td>{{ $advanceApplication->status }}</td>
                    <td>
                        <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptleave{{ $advanceApplication->id }}">Accept</a>
                        <a href="" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
                <div class="modal" id="acceptleave{{ $advanceApplication->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Approval</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form method="POST" action="{{ route('advance.approve', ['id' => $advanceApplication->id]) }}">
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
