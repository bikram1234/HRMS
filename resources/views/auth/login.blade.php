
@extends('auth.partial.login_app')
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
                    <form method="POST" action="{{route('login')}}">
		                    @csrf
								<div class="form-group">
									<input class="form-control"type="text" id="email"  placeholder="Email" name="email">
									@error('email')<span class="text-danger">{{ $message }}</span>
                                    @enderror
								</div>

								<div>
								<div class="form-group position-relative">
									<input class="form-control" type="password" id="password" name="password" placeholder="Password">
									<!-- <i class="bi bi-eye-slash-fill eye-icon"></i> -->
									@error('password')<span class="text-danger">{{ $message }}</span>
                       				 @enderror
								</div>
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
									<button class="btn btn-primary account-btn" type="submit">Login</button>
								</div>

                                <div class="justify-content-center">
                                <a href="{{ route('register') }}">Register</a>
                                </div>
                        </form>
							<!-- /Account Form -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        // Auto-hide the success message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>

@endsection