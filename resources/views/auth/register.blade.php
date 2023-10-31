
@extends('auth.partial.register_app')
@section('content')

@if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
@endif
        @if(session('error'))
            <div id="error-message" class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
          <!-- Account Form -->
                    <form method="POST" action="{{ route('register.post') }}">
		                @csrf
                        <div class="form-group">
                            <input class="form-control"type="text" id="name"  placeholder="Name" name="name">
                            @error('name')<span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control"type="email" id="email"  placeholder="Email" name="email">
                            @error('email')<span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control"type="text" id="employee_id"  placeholder="Employee ID" name="employee_id">
                            @error('employee_id')<span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group position-relative">
                            <input class="form-control" type="password" id="cpassword" name="password" placeholder="Password" autocomplete="current-password">
                            <!-- <i class="bi bi-eye-slash-fill eye-icon"></i> -->
                            @error('password')<span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>

                        <div class="form-group position-relative">
                            <input class="form-control" type="password" id="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="current-password">
                            <!-- <i class="bi bi-eye-slash-fill eye-icon"></i> -->
                            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    

								<div class="row">
										<div class="col-auto ml-auto">
                                            @if (Route::has('password.request'))
											<a class="text-muted" href="{{ route('password.request') }}">
												{{__('Forgot Your Password?')}}
											</a>
                                            @endif
                                            
										</div>
									</div>
								</div>
								<div class="form-group text-center justify-content-center">
									<button class="btn btn-primary account-btn" type="submit">Register</button>
								</div>
                        </form>
							<!-- /Account Form -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Assuming you're using jQuery
$('#department').on('change', function() {
    var departmentId = $(this).val();
    
    $.ajax({
        url: '/sections/' + departmentId,
        method: 'GET',
        success: function(response) {
            console.log("thIS IS THE ",response);
            var sections = response.sections;
            var sectionDropdown = $('#section'); // Change this selector accordingly
            
            // Clear existing options and populate the dropdown
            sectionDropdown.empty();
            sectionDropdown.append('<option value="">Select Section</option>');
            
            $.each(sections, function(index, section) {
                sectionDropdown.append('<option value="' + section.id + '">' + section.name + '</option>');
            });
        }
    });
});

</script>

@endsection