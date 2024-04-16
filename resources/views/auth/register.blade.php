@extends('main_master')
@section('content')
@section('title')
    Login
@endsection
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="{{ asset('assets/images/rick-and-morty-register.jpg') }}" class="img-fluid  mb-5"
                    alt="">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="name">Name</label>
                        <input type="name" id="name" name="name" required autofocus autocomplete="name"
                            class="form-control form-control-lg" />
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" name="email" required autofocus autocomplete="username"
                            class="form-control form-control-lg" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            class="form-control form-control-lg" />
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            autocomplete="new-password" class="form-control form-control-lg" />
                    </div>


                    <center>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                        <hr>

                        Already have an account? <a href="login" class="form-check-label"> Log in</a>
                    </center>


                </form>
            </div>
        </div>
    </div>
</section>
@endsection
