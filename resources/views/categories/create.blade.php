@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <h2 class="card-title mb-4">{{ __('Tạo danh mục mới') }}</h2>

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Tên danh mục') }}</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Màu sắc -->
                    <div class="mb-3">
                        <label for="color" class="form-label">{{ __('Màu sắc') }}</label>
                        <div class="d-flex align-items-center">
                            <input id="color" name="color" type="color" class="form-control form-control-color" value="{{ old('color', '#3490dc') }}" required>
                            <span class="ms-2">Chọn màu cho danh mục</span>
                        </div>
                        @error('color')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">{{ __('Tạo danh mục') }}</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection