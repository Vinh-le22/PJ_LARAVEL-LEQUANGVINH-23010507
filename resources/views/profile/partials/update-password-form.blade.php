<!-- 
    File: update-password-form.blade.php
    Mô tả: Form cập nhật mật khẩu người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Cập nhật mật khẩu') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Đảm bảo tài khoản của bạn sử dụng mật khẩu dài và ngẫu nhiên để được bảo mật.') }}
        </p>
    </header>

    <!-- Form cập nhật mật khẩu -->
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Trường nhập mật khẩu hiện tại -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Mật khẩu hiện tại') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Trường nhập mật khẩu mới -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Mật khẩu mới') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Trường xác nhận mật khẩu mới -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Xác nhận mật khẩu mới') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nút lưu mật khẩu -->
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>

            @if (session('status') === 'password-updated')
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
