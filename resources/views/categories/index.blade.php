@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Quản lý danh mục</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Danh sách danh mục</h5>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">Tạo danh mục mới</a>
                    </div>
                    
                    @if($categories->isEmpty())
                        <p class="text-center">Không có danh mục nào.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên danh mục</th>
                                        <th>Màu sắc</th>
                                        <th>Số công việc</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="color-dot me-2" style="background-color: {{ $category->color }};"></span>
                                                    {{ $category->name }}
                                                </div>
                                            </td>
                                            <td>{{ $category->color }}</td>
                                            <td>{{ $category->tasks->count() }}</td>
                                            <td>
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-primary">Sửa</a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
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

<style>
    .color-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endsection