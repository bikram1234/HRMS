@extends('layout')

@section('content')

        
@if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="{{ route('section.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Section Name:</label>
            <input type="text" class="form-control" id="name" name="name">
            @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        
        <div class="form-group">
            <label for="head">Department Name:</label>
            <select class="form-control" id="head" name="department">
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
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Add Department</button>
    </form>
</div>

@endsection