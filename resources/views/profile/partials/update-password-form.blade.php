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
        <div>
            <x-input-label for="update_password_current_password" :value="__('Mật khẩu hiện tại')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- Trường nhập mật khẩu mới -->
        <div>
            <x-input-label for="update_password_password" :value="__('Mật khẩu mới')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Trường xác nhận mật khẩu mới -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Xác nhận mật khẩu mới')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Nút lưu mật khẩu -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Lưu') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Đã lưu.') }}</p>
            @endif
        </div>
    </form>
</section>
