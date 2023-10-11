@extends('layout') <!-- Extend your layout file -->

@section('content')
<div class="container">
    <h1>Pending and Approved Expense Applications</h1>

    <form action="{{ route('transfer.approval.index') }}" method="GET">
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
                <th>Transfer Claim Type</th>
                <th>Claim Amount</th>
                <th>Current Location</th>
                <th>New Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transfer_approval as $transfer)
            <tr>
                <td>
                    <input type="checkbox" class="selectSingle" name="selected[]" value="{{ $transfer->id }}">
                </td>
                <td>{{ $transfer->Username->name }}</td>
                <td>{{ $transfer->transfer_claim_type }}</td>
                <td>{{ $transfer->claim_amount }}</td>
                <td>{{ $transfer->current_location }}</td>
                <td>{{ $transfer->new_location }}</td>
                <td>{{ $transfer->status }}</td>
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
@endsection
