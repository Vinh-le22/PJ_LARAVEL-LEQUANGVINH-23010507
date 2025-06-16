<!-- 
    File: edit.blade.php
    Mô tả: Trang chỉnh sửa thông tin hồ sơ người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Hồ sơ') }}
        </h2>

        <div class="space-y-6">
            <!-- Form cập nhật thông tin hồ sơ -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Form cập nhật mật khẩu -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Form xóa tài khoản -->
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
