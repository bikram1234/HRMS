@extends('layout')

@section('content')

<div class="container mt-5">
    <h1>This is section edit page</h1>
    <form method="POST" action="{{ route('section.update', $section->id) }}">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="name">section Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $section->name) }}" required>
                @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>


            <div class="form-group">
                <label for="head">Department Name:</label>
                <select class="form-control" id="head" name="department">
                <option value="{{ $section->department }}">Select Department</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                <option value="{{ $section->status }}">Select Status:</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update section</button>
        </form>
</div>

@endsection