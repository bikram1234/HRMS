@extends('layout')
@section('content')

    <div class="container mt-5">
        
    @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{route('leavetype.create')}}" class="btn btn-primary mb-2">Add New Leavetype</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Short code</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($leavetypes->count() > 0)
                @foreach($leavetypes as $leavetype)
                    <tr>
                        <td>{{ $leavetype->name }}</td>
                        <td>{{ $leavetype->short_code }}</td>
                         @if($leavetype->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                        <td>
                            <a href="{{ route('leavetype.edit', $leavetype->id) }}" class="btn btn-primary btn-sm">Edit</a>
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