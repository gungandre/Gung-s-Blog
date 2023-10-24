@extends('layouts.main')

@section('container')
    <main class="form-signin w-100 m-auto">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf

            <h1 class="h3 mb-3 fw-normal">Please Login</h1>

            <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput"
                    name="email" placeholder="Email" value="{{ old('email') }}" autofocus required>
                <label for="floatingInput">Email address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                <label for="Password">Password</label>
            </div>


            <button class="btn btn-primary w-100 py-2" type="submit">Login</button>

        </form>
        <small class="d-block text-center mt-3">Not registered? <a href="/register">Register Now!</a></small>
    </main>
@endsection
