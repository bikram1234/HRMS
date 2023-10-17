
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
                                <li class="breadcrumb-item active">Dashboard/Setting Management/Permission</li>
                            </ul>
                        </div>                     
                    </div>
                </div>
                <!-- /Page Header -->        
        <div class="container">
        @foreach ($rolesWithPermissions as $role)
            <h2>{{ $role->name }} Permissions:</h2>
            <ul>
                @foreach ($role->permissions as $permission)
                    <li>{{ $permission->name }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>

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



