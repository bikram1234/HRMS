@extends('layout') <!-- Assuming you have a layout file -->

 <!-- Assuming you have a layout file -->

@section('content')
    <div class="container">
        <h1>Permissions List</h1>
        
        @foreach ($rolesWithPermissions as $role)
            <h2>{{ $role->name }} Permissions:</h2>
            <ul>
                @foreach ($role->permissions as $permission)
                    <li>{{ $permission->name }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
@endsection

