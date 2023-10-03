@extends('layout')

@section('content')

<h1>This is department edit page</h1>
<form method="POST" action="{{ route('department.update', $department->id) }}">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="name">Department Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $department->name) }}" required>
            @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>


        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
            <option value="{{ $department->status }}">Select Status:</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update Department</button>
    </form>

@endsection