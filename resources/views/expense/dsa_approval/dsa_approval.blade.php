{{-- @extends('layout') <!-- Extend your layout file -->

@section('content')
<div class="container">
    <h1>Dsa Approval Applications</h1>

    <form action="{{ route('dsa.approval.index') }}" method="GET">
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
                <th>Total Amount Adjusted</th>
                <th>Net Payable Amount</th>
                <th>Balance Amount</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($dsaSettlements as $dsaSettlement)
            <tr>
                <td>
                    <input type="checkbox" class="selectSingle" name="selected[]" value="{{ $dsaSettlement->id }}">
                </td>
                <td>{{ $dsaSettlement->user->name }}</td>
                <td>{{ $dsaSettlement->total_amount_adjusted }}</td>
                <td>{{ $dsaSettlement->net_payable_amount }}</td>
                <td>{{ $dsaSettlement->balance_amount }}</td>
                <td>
                    <a href="{{ route('dsa-settlement.view', ['id' => $dsaSettlement->id]) }}"
                       style="color: {{ $dsaSettlement->status === 'pending' ? 'orange' : ($dsaSettlement->status === 'approved' ? 'green' : 'red') }};">
                        {{ $dsaSettlement->status }}
                    </a>
                </td>
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


@extends('layout')  <!-- Extend your layout file -->

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
    <table class="table">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Total Amount Adjusted</th>
                <th>Net Payable Amount</th>
                <th>Balance Amount</th>
                <th>Status</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($expenseApplications as $expenseApplication)
                <tr>
                    <td>{{ $expenseApplication->user->name }}</td>
                    <td>{{ $expenseApplication->total_amount_adjusted }}</td>
                    <td>{{ $expenseApplication->net_payable_amount }}</td>
                    <td>{{ $expenseApplication->balance_amount }}</td>
                    <td>
                    <a
                        style="color: {{ $expenseApplication->status === 'pending' ? 'orange' : ($expenseApplication->status === 'approved' ? 'green' : 'red') }};">
                         {{ $expenseApplication->status }}
                     </a>


                    <td>
                        <a type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptleave{{ $expenseApplication->id}}">Approve</a>
                        <a type="button"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#declineleave{{ $expenseApplication->id}}">Reject</a> 
                        <a href="{{ route('dsa-settlement.view', ['id' => $expenseApplication->id]) }}" class="btn btn-primary btn-sm">View</a> 
                        </td>
                <div class="modal" id="acceptleave{{ $expenseApplication->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Approval</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('dsa.approve', ['id' => $expenseApplication->id]) }}">
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
                            <form method="POST" action="{{ route('dsa.reject', ['id' => $expenseApplication->id]) }}">
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

@endsection