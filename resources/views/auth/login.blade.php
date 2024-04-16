@extends('main_master')
@section('content')
@section('title')
    Login
@endsection
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="{{ asset('assets/images/rick-and-morty-login.jpg') }}" class="img-fluid  mb-5" alt="">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" name="email" required autofocus autocomplete="username"
                            class="form-control form-control-lg" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                            class="form-control form-control-lg" />
                    </div>

                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <label class="form-check-label" for="form1Example3"> Remember me </label>
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember" checked />
                        </div>
                    </div>

                    <center>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                        <hr>

                        If you don't have an account, <a href="register" class="form-check-label"> sign up.</a>
                    </center>


                </form>
            </div>
        </div>
    </div>
</section>
@endsection
