@extends('layouts.main')

@section('container')
    <main class="form-signin w-100 m-auto">
        <form action="/register" method="POST">
            {{-- setiap kita melakukan method post, kita harus menginsialisasi @csrf untuk session token di laravel. ini untuk keamanan --}}
            @csrf


            <h1 class="h3 mb-3 fw-normal">Registration Form</h1>

            <div class="form-floating">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingInput" name="name"
                    placeholder="Name" value="{{ old('name') }}">
                <label for="floatingInput">Name</label>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="text" class="form-control  @error('username') is-invalid @enderror" id="floatingInput"
                    name="username" placeholder="Username" value="{{ old('username') }}">
                <label for="floatingInput">Username</label>
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput"
                    name="email" placeholder="Email" value="{{ old('email') }}">
                <label for="floatingInput">Email</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword"
                    name="password" placeholder="Password" value="{{ old('password') }}">
                <label for="floatingPassword">Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <button class="btn btn-primary w-100 py-2" type="submit">Register</button>

        </form>
        <small class="d-block text-center mt-3">Already registered? <a href="/login">Login</a></small>
    </main>
@endsection
