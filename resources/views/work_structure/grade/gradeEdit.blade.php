@extends('layout')

@section('content')

<div class="container mt-5">
    <h1>This is grade edit page</h1>
    <form method="POST" action="{{ route('grade.update', $grade->id) }}">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="name">grade Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $grade->name) }}">
                @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                <option value="{{ $grade->status }}">Select Status:</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update grade</button>
        </form>
</div>

@endsection