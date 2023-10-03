@extends('layout')
@section('content')

    <div class="container mt-5">
        
    @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{route('designation.create')}}" class="btn btn-primary mb-2">Add New Designation</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Designation Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($designations->count() > 0)
                @foreach($designations as $designation)
                    <tr>
                        <td>{{ $designation->name }}</td>
                         @if($designation->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                        <td>
                            <a href="{{ route('designation.edit', $designation->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('designation.delete', $designation->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave type?')">Delete</button>
                            </form>
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