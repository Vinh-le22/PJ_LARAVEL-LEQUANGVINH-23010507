<!-- 
    File: register.blade.php
    Mô tả: Trang đăng ký tài khoản người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
@extends('layouts.guest')

@section('content')
    <div class="container d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h2 class="text-center mb-4">Đăng ký tài khoản</h2>
                <p class="text-center text-muted mb-4">
                    Hoặc
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        đăng nhập nếu đã có tài khoản
                    </a>
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Họ và tên') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control" placeholder="Nhập họ và tên của bạn">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control" placeholder="Nhập email của bạn">
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Mật khẩu') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control" placeholder="Nhập mật khẩu của bạn">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Xác nhận mật khẩu') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" placeholder="Nhập lại mật khẩu của bạn">
                        @error('password_confirmation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('Đăng ký') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
