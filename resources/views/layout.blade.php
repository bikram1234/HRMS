<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'HRMS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'HRMS') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    WorkStructure
                                </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @can('read: department')
                                        <a class="dropdown-item" href="{{ route('department.index') }}">{{ __('Department') }}</a>
                                        @endcan
                                        @can('read: section')
                                        <a class="dropdown-item" href="{{ route('section.index') }}">{{ __('Section') }}</a>
                                        @endcan
                                        @can('read: designation')
                                        <a class="dropdown-item" href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                                        @endcan
                                        @can('read: role')
                                        <a class="dropdown-item" href="{{ route('role.index') }}">{{ __('Role') }}</a>
                                        @endcan
                                        @can('read: grade')
                                        <a class="dropdown-item" href="{{ route('grade.index') }}">{{ __('Grade') }}</a>
                                        @endcan                       
                                        <a class="dropdown-item" href="{{ route('country.index') }}">{{ __('Geography') }}</a>   
                                        <a class="dropdown-item" href="{{ route('holiday.index') }}">{{ __('Holiday') }}</a>          
                                    </div>
                            </div>

                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    No Due
                                </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('nodue.index') }}">{{ __('Apply') }}</a>
                                        <a class="dropdown-item" href="{{ route('nodueapproval.index') }}">{{ __('Approval') }}</a>
                                    </div>
                            </div>
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Settings
                                </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('permission.index') }}">{{ __('Permission') }}</a>
                                        <a class="dropdown-item" href="{{ route('hierarchy.index') }}">{{ __('Hierarchy') }}</a>
                                        <a class="dropdown-item" href="{{ route('approval.index') }}">{{ __('ApprovalRules') }}</a>
                                    </div>
                            </div>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Home') }}</a>
                                </li>
                                <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Leave
                                </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('leavetype.index') }}">{{ __('Types') }}</a>
                                        <a class="dropdown-item" href="{{ route('leavepolicy.index') }}">{{ __('Policy') }}</a>
                                        <a class="dropdown-item" href="{{ route('leave.history') }}">{{ __('Apply') }}</a>
                                        <a class="dropdown-item" href="{{ route('leaveApproval.index')}}">Approval</a>
                                        <a class="dropdown-item" href="{{ route('encashment_approval.index')}}">Encashment Approval</a>
                                    </div>
                            </div>
                                <!-- Add this code to your HTML template where you want the dropdown to appear -->

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.create') }}">{{ __('Employee') }}</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}">{{ __('Logout') }}</a>
                                </li>
                                <p>Your Role: {{ auth()->user()->roles->pluck('name')->implode(', ') }}</p>
            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        // Initialize Bootstrap components (if not already done)
        $('[data-toggle="dropdown"]').dropdown();
    });
</script>

</body>
</html>
