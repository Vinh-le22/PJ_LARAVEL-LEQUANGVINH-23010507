<!-- 
    File: dashboard.blade.php
    Mô tả: Trang bảng điều khiển chính
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm rounded-lg text-center p-4">
            <h3 class="h3 mb-3" style="color: var(--cb-text-dark);">Chào mừng {{ Auth::user()->name }} đến với web quản lý công việc!</h3>
        </div>

        <div class="row mt-4">
            <!-- Thống kê công việc -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded-lg p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 0 00-2 2v12a2 0 002 2h10a2 0 002-2V7a2 0 00-2-2h-2M9 5a2 0 002 2h2a2 0 002-2M9 5a2 0 012-2h2a2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="text-muted text-uppercase mb-0">Tổng số công việc</h5>
                            <p class="h4 mb-0">{{ \App\Models\Task::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Công việc đang thực hiện -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded-lg p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <svg class="h-6 w-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="text-muted text-uppercase mb-0">Đang thực hiện</h5>
                            <p class="h4 mb-0">{{ \App\Models\Task::where('status', 'in_progress')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Công việc đã hoàn thành -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded-lg p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <svg class="h-6 w-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="text-muted text-uppercase mb-0">Đã hoàn thành</h5>
                            <p class="h4 mb-0">{{ \App\Models\Task::where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 justify-content-center mt-4">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                ➕ Tạo công việc mới
            </a>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                📋 Xem danh sách công việc
            </a>
        </div>
    </div>
@endsection
