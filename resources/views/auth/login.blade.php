@extends('layouts.app') @section('content')
<div class="container">
    <div class="row align-items-center justify-content-center vh-100">
        <div class="col-md-7">
            <img
                src="{{ asset('img/logo-agro-s.png') }}"
                class="w-50"
            />
            <h3>
                Berbagi informasi, konten edukasi, dan konsultasi dengan tenaga
                ahli.
            </h3>
        </div>
        <div class="card" style="width: 20rem;"> 
            <div class="card-header text-center">{{ __("Login") }}</div>
            <div class="card-body">
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="Email"
                                />

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                    </div>

                    <div class="mb-3">
                        <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Password"
                    />

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                        
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                name="remember" id="remember"
                                {{ old("remember") ? "checked" : "" }}>

                                <label class="form-check-label" for="remember">
                                    {{ __("Remember Me") }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <div class="offset-md-8"><button type="submit" class="btn btn-primary">
                                {{ __("Login") }}
                            </button>
                        </div>
                        <div class="offset-md-3">
                            @if (Route::has('password.request'))
                            <a
                                class="btn btn-link"
                                href="{{ route('password.request') }}"
                            >
                                {{ __("Forgot Your Password?") }}
                            </a>
                            @endif
                        </div>
                        </div>
                    </form>
                    
                </div>
                
            </div>
            <div class="card-footer text-center">
                <p>Belum Memiliki Akun ? <br>Daftar Disini</p>
                <div class="offset-md-12"><button type="submit" class="btn btn-success">
                    {{ __("Daftar") }}
                </button>
            </div>
         </div>
        </div>
    </div>
</div>
@endsection
