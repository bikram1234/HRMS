@extends('layout') <!-- Assuming you have an app.blade.php layout -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registration') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mt-4">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee ID:</label>

                                <div class="col-md-6">
                                    <input id="employee_id" type="text" class="form-control" name="employee_id" required autofocus>
                                </div>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="department">Department Name:</label>
                                <select class="form-control" id="department" name="department" onchange="loadSections()">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="section">Section Name:</label>
                                <select class="form-control" id="section" name="section">
                                    <!-- Options will be dynamically added using JavaScript -->
                                </select>
                                @error('section_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group row  mt-4">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>

                                <div class="col-md-6">
                                    <select id="user_id" class="form-control" name="role" required>
                                        <option value="" disabled selected>Select Role</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row  mt-4">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Designation</label>

                                <div class="col-md-6">
                                    <select id="user_id" class="form-control" name="designation" required>
                                        <option value="" disabled selected>Select Designation</option>
                                            @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                            @endforeach
                                        </select>

                                    @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row  mt-4">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Grade</label>

                                <div class="col-md-6">
                                    <select id="user_id" class="form-control" name="grade" required>
                                        <option value="" disabled selected>Select Grade</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>

                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="#">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
    // Get references to the department and section dropdowns
    var departmentDropdown = document.getElementById('department');
    var sectionDropdown = document.getElementById('section');

    // Add an event listener to the department dropdown
    departmentDropdown.addEventListener('change', function() {
        var departmentId = this.value;

        // Clear existing options
        sectionDropdown.innerHTML = '';

        // Make an AJAX request to fetch sections based on the selected department
        fetch('/sections/' + departmentId)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                var sections = data.sections;

                // Add a default "Select Section" option
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Section';
                sectionDropdown.appendChild(defaultOption);

                // Populate the section dropdown with fetched data
                sections.forEach(function(section) {
                    var option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    sectionDropdown.appendChild(option);
                });
            })
            .catch(function(error) {
                console.error('Error fetching sections:', error);
            });
    });
</script>

@endsection
