@extends('layout')

@section('content')

<div class="container mt-5">
    <h1>This is leavetype edit page</h1>
    <form method="POST" action="{{ route('leavetype.update', $leavetype->id) }}">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="name">leavetype Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $leavetype->name) }}" required>
                @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <div class="form-group">
                <label for="short_code">leavetype Name:</label>
                <input type="text" class="form-control" id="short_code" name="short_code" value="{{ old('short_code', $leavetype->short_code) }}" required>
                @error('short_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                <option value="{{ $leavetype->status }}">Select Status:</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update leavetype</button>
        </form>
</div>
    
@endsection