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
        <a href="{{ route('approval.create') }}" class="btn btn-primary mb-2">Add New Approval</a>
        <a href="{{ route('approval.create') }}" class="link-secondary">Leave Encashment</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Rule Name</th>
                    <th>start_date</th>
                    <th>end_date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($EncashmentApprovals->count() > 0)
                @foreach($EncashmentApprovals as $Encashmentapproval)
                    <tr>
                        <td>{{ $Encashmentapproval->type->name }}</td>
                        <td>{{ $Encashmentapproval->RuleName }}</td>
                        <td>{{ $Encashmentapproval->start_date }}</td>
                        <td>{{ $Encashmentapproval->end_date }}</td>
                        <td>
                            <a href="{{ route('approval_encashment.show', ['leaveEncashmentApprovalRule' => $Encashmentapproval->id])}}" class="btn btn-primary btn-sm">Edit</a>
                          
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