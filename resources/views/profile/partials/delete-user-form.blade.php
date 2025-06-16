<!-- 
    File: delete-user-form.blade.php
    Mô tả: Form xóa tài khoản người dùng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Xóa tài khoản') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Khi tài khoản của bạn bị xóa, tất cả dữ liệu và tài nguyên sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.') }}
        </p>
    </header>

    <!-- Nút mở modal xóa tài khoản -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Xóa tài khoản') }}
    </button>

    <!-- Modal xác nhận xóa tài khoản -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="confirmUserDeletionModalLabel">
                            {{ __('Bạn có chắc chắn muốn xóa tài khoản của mình?') }}
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Khi tài khoản của bạn bị xóa, tất cả dữ liệu và tài nguyên sẽ bị xóa vĩnh viễn. Vui lòng nhập mật khẩu của bạn để xác nhận việc xóa tài khoản.') }}
                        </p>

                        <!-- Trường nhập mật khẩu xác nhận -->
                        <div class="mt-3">
                            <label for="password" class="form-label visually-hidden">{{ __('Mật khẩu') }}</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control mt-1"
                                placeholder="{{ __('Mật khẩu') }}"
                            />
                            @error('password', 'userDeletion')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Các nút điều khiển -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Hủy') }}
                        </button>

                        <button type="submit" class="btn btn-danger ms-3">
                            {{ __('Xóa tài khoản') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
