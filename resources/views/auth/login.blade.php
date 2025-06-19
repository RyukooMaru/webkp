@extends('layouts.auth') {{-- Pastikan layout ini memuat semua aset yang diperlukan (CSS, JS) --}}

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                </div>

                                {{-- Menampilkan validasi error dari Laravel --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="user">
                                    @csrf {{-- Token CSRF untuk keamanan form --}}

                                    <div class="form-group">
                                        {{-- Input untuk Nama Pengguna / ID Member --}}
                                        <input type="text" 
                                               class="form-control form-control-user @error('Mem_UserName') is-invalid @enderror" 
                                               name="Mem_UserName" 
                                               id="Mem_UserName" {{-- Tambahkan ID untuk autocomplete --}}
                                               placeholder="{{ __('Nama Pengguna') }}" 
                                               value="{{ old('Mem_UserName') }}" 
                                               required 
                                               autocomplete="username" {{-- Autocomplete untuk browser --}}
                                               autofocus>

                                        @error('Mem_UserName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        {{-- Input untuk Password --}}
                                        <input type="password" 
                                               class="form-control form-control-user @error('password') is-invalid @enderror" 
                                               name="mem_password" {{-- Ganti name dari 'password' menjadi 'mem_password' --}}
                                               id="mem_password" {{-- Tambahkan ID untuk autocomplete --}}
                                               placeholder="{{ __('Password') }}" 
                                               required 
                                               autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">{{ __('Ingat Saya') }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    <hr>

                                </form>

                                <hr>

                                @if (Route::has('password.request'))
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">
                                            {{ __('Lupa Password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection