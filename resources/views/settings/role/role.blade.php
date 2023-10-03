@extends('layout')
@section('content')

    <div class="container mt-5">
        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{route('role.create')}}" class="btn btn-primary mb-2">Add New Role</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($roles->count() > 0)
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            @if($role->status == 1 )
                                <td>Active</td>
                            @else
                                <td>Inactive</td>
                            @endif
                            <td>
                                @can('update: role') <!-- Check if the user has 'edit role' permission -->
                                    <a href="{{ route('role.edit', $role->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                @endcan
                                @can('delete: role') <!-- Check if the user has 'delete role' permission -->
                                    <form action="{{ route('role.delete', $role->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3"><h1>No data</h1></td>
                    </tr>
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
