<!-- 
    File: create.blade.php
    Mô tả: Trang tạo công việc mới
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <h2 class="card-title mb-4">{{ __('Tạo công việc mới') }}</h2>

                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <!-- Tiêu đề -->
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Tiêu đề') }}</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{ old('title') }}" required autofocus>
                        @error('title')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Mô tả') }}</label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('Trạng thái') }}</label>
                        <select id="status" name="status" class="form-select">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Đang thực hiện</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hạn hoàn thành -->
                    <div class="mb-3">
                        <label for="due_date" class="form-label">{{ __('Hạn hoàn thành') }}</label>
                        <input id="due_date" name="due_date" type="date" class="form-control" value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">{{ __('Tạo công việc') }}</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 