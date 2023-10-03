@extends('layout')

@section('content')
<div class="container mt-5">
<h1>This is role edit page</h1>
@can('create: role')
<form method="POST" action="{{ route('role.update', $role->id) }}">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="name">Role Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
            @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        @foreach ($permissions as $permission)
                <div>
                    <input type="checkbox"
                           name="permissions[]"
                           value="{{ $permission->id }}"
                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </div>
            @endforeach


        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
            <option value="{{ $role->status }}">Select Status:</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update role</button>
    </form>
    @endcan
</div>
@endsection