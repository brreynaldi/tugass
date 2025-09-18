@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<style>
    body {
        background: url('/images/back.jpeg') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
    }

    .login-logo {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
        display: block;
        margin: 0 auto 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    /* Responsif untuk tablet */
    @media (max-width: 768px) {
        .login-logo {
            width: 150px;
            height: 150px;
        }
    }

    /* Responsif untuk HP */
    @media (max-width: 480px) {
        .login-logo {
            width: 100px;
            height: 100px;
        }
    }
</style>

<div class="container">
    
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        
        <div class="col-md-6">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" width="100" class="login-logo">
                <br/>
            <div class="card shadow-lg border-0 rounded-3">
                
                <div class="card-header text-center bg-primary text-white">
                    
                    <h4 class="mb-0">{{ __('Login') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
