@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Danh sách công việc</h2>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thống kê công việc</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="text-center">
                                <h3>{{ $stats['total'] }}</h3>
                                <p>Tổng số</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <h3>{{ $stats['pending'] }}</h3>
                                <p>Đang chờ</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <h3>{{ $stats['in_progress'] }}</h3>
                                <p>Đang thực hiện</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <h3>{{ $stats['completed'] }}</h3>
                                <p>Hoàn thành</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <h3>{{ $stats['overdue'] }}</h3>
                                <p>Quá hạn</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc và sắp xếp -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Đang thực hiện</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Tất cả</option>
                                @foreach(Auth::user()->categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Sắp xếp theo</label>
                            <select name="sort" id="sort" class="form-select">
                                <option value="">Mới nhất</option>
                                <option value="due_date_asc" {{ request('sort') == 'due_date_asc' ? 'selected' : '' }}>Thời hạn tăng dần</option>
                                <option value="due_date_desc" {{ request('sort') == 'due_date_desc' ? 'selected' : '' }}>Thời hạn giảm dần</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary ms-2">Đặt lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách công việc -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Danh sách công việc</h5>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Tạo công việc mới</a>
                    </div>
                    
                    @if($tasks->isEmpty())
                        <p class="text-center">Không có công việc nào.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Thời hạn</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                @if($task->category)
                                                    <span class="badge" style="background-color: {{ $task->category->color }}">{{ $task->category->name }}</span>
                                                @else
                                                    <span class="text-muted">Không có</span>
                                                @endif
                                            </td>
                                            <td>
                                                @switch($task->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Đang chờ</span>
                                                        @break
                                                    @case('in_progress')
                                                        <span class="badge bg-info">Đang thực hiện</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-success">Hoàn thành</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Không có' }}</td>
                                            <td>
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary">Sửa</a>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection