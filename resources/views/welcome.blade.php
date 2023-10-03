@extends('layout') <!-- Extend the layout.blade.php file -->

@section('content')
    <!-- Your HR dashboard content goes here -->

    <!DOCTYPE html>
<html>
<head>
    <title>Add Leave Type</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <h1>HR Dashboard</h1>
    <p>Welcome to the HR dashboard!</p>

        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


    </div>


</body>
</html>


@endsection
