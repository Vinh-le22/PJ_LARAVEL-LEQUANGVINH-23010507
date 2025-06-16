<!-- 
    File: update-profile-information-form.blade.php
    Mô tả: Form cập nhật thông tin hồ sơ người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Thông tin hồ sơ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Cập nhật thông tin hồ sơ và địa chỉ email của bạn.') }}
        </p>
    </header>

    <!-- Form gửi email xác thực -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form cập nhật thông tin -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Trường nhập tên -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Họ và tên') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Trường nhập email -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Địa chỉ email của bạn chưa được xác thực.') }}

                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('Nhấn vào đây để gửi lại email xác thực.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Một liên kết xác thực mới đã được gửi đến địa chỉ email của bạn.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Nút lưu thông tin -->
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success ms-3"
                >{{ __('Đã lưu.') }}</p>
            @endif
        </div>
    </form>
</section>
