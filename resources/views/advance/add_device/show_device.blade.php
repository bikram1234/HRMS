<!-- show_device.blade.php -->

@extends('layout')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('device.create') }}" class="btn btn-primary">Add Device</a>
    </div>

    <h1>Device List</h1>
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

    <!-- Display devices in a table format with pagination -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($device as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>
                        <a href="{{ route('device.edit', $item) }}" class="btn btn-primary">Edit</a>
                        <form style="display: inline-block;" action="{{ route('device.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
