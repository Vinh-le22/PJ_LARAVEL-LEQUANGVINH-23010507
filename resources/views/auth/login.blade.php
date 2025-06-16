<!-- 
    File: login.blade.php
    Mô tả: Trang đăng nhập người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
@extends('layouts.guest')

@section('content')
    <div class="container d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h2 class="text-center mb-4">Đăng nhập</h2>
                <p class="text-center text-muted mb-4">
                    Hoặc
                    <a href="{{ route('register') }}" class="text-decoration-none">
                        đăng ký tài khoản mới
                    </a>
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control" placeholder="Nhập email của bạn">
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Mật khẩu') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" placeholder="Nhập mật khẩu của bạn">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">{{ __('Ghi nhớ đăng nhập') }}</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-decoration-none" href="{{ route('password.request') }}">
                                {{ __('Quên mật khẩu?') }}
                            </a>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('Đăng nhập') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
