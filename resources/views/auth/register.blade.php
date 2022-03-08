@extends('templates.main')

@section('content')
<div class="overflow-hidden">
    <div class="row vh-100 g-0">
        <div class="col bg-secondary">
            <img src="https://images.pexels.com/photos/4386321/pexels-photo-4386321.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
        </div>
        <div class="d-flex justify-content-center align-items-center col">
            <form method="POST" action="{{ route('register') }}" style="width: 23rem;">
                @csrf
                <h1 class="fw-bold">Sign Up Now</h1>
                <p class="text-secondary">Please fill in the form below</p>
                <div class="mb-2">
                    <label for="fname" class="form-label fw-bold">First Name</label>
                    <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" id="fname" aria-describedby="first name" value="{{ old('fname') }}" autocomplete="none">
                    @error('fname')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="lname" class="form-label fw-bold">Last Name</label>
                    <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" id="lname" aria-describedby="last name" value="{{ old('lname') }}" autocomplete="none">
                    @error('lname')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="email" value="{{ old('email') }}" autocomplete="none">
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>
                <div class="mb-2 form-check">
                    <div>
                        <input type="checkbox" class="form-check-input" id="remember_me">
                        <label class="form-check-label fw-bold" for="terms">
                            I agree to the
                            <a href="#" class="text-decoration-none fw-bold">Terms & Conditions</a>
                        </label>
                    </div>
                </div>
                <button type="submit" class="primary-btn w-100 text-white py-2 mb-4">Create Account</button>
                <a href="/login" class="text-decoration-none text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to home
                </a>
            </form>
        </div>
    </div>
</div>
@endsection