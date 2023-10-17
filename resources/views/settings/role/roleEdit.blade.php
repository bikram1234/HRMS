
@extends('layouts.index')

@section('content')
<style>
 .status-button {
background-color:#17c964;
 border-radius: 30px;
}

.status-button:hover{
    background-color:#17c964;
}
.inactive-button {
background-color:#f5a524;
 border-radius: 30px;
}

.inactive-button:hover{
    background-color:#f5a524;
}

.icon-spacing {
    margin-left: 10px; /* Adjust the value to control the spacing */
    display: inline-block; /* Ensures the span takes up space */
}

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
            
            <!-- Page Content -->
            <div class="content container-fluid">
            @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Roles</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Setting Management/Role</li>
                            </ul>
                        </div>                     
                    </div>
                </div>
                <!-- /Page Header -->         
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
<!-- /Page Content -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#selectAllCheckbox').change(function() {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
});
</script>

<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>


@endsection



