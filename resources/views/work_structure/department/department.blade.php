@extends('layout')
@section('content')

    <div class="container mt-5">
        
    @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{route('department.create')}}" class="btn btn-primary mb-2">Add New Departent</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Departent(head)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($departments->count() > 0)
                @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->name }}</td>
                        <td></td>
                         @if($department->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                        <td>
                            <a href="{{ route('department.edit', $department->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('department.delete', $department->id) }}" method="POST" class="d-inline">
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