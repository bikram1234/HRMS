@extends('layout')
@section('content')

    <div class="container mt-5">
        
    @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('leavepolicy.create') }}" class="btn btn-primary mb-2">Add New leave_policy</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Policy Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($leave_policies->count() > 0)
                @foreach($leave_policies as $leave_policy)
                    <tr>
                        <td>{{ $leave_policy->policy_name }}</td>
                        <td>{{ $leave_policy->leavetype->name }}</td>
                        <td>{{ $leave_policy->start_date }}</td>
                        <td>{{ $leave_policy->end_date }}</td>
                        @if($leave_policy->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Draft</td>
                         @endif
                        <td>
                            <a href="" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('leavePolicy.view', ['leave_id' => $leave_policy->leave_id])}}" class="btn btn-primary btn-sm">View</a> 
                        </td>
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
    <script>
        // Auto-hide the success message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>


@endsection