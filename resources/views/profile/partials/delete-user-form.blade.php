<!-- 
    File: delete-user-form.blade.php
    Mô tả: Form xóa tài khoản người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Xóa tài khoản') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Khi tài khoản của bạn bị xóa, tất cả dữ liệu và tài nguyên sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.') }}
        </p>
    </header>

    <!-- Nút mở modal xóa tài khoản -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Xóa tài khoản') }}</x-danger-button>

    <!-- Modal xác nhận xóa tài khoản -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Bạn có chắc chắn muốn xóa tài khoản của mình?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Khi tài khoản của bạn bị xóa, tất cả dữ liệu và tài nguyên sẽ bị xóa vĩnh viễn. Vui lòng nhập mật khẩu của bạn để xác nhận việc xóa tài khoản.') }}
            </p>

            <!-- Trường nhập mật khẩu xác nhận -->
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Mật khẩu') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Mật khẩu') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Các nút điều khiển -->
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Hủy') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Xóa tài khoản') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
