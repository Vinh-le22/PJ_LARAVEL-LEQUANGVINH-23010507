<!-- 
    File: navigation.blade.php
    Mô tả: Menu điều hướng chính của ứng dụng
    Tác giả: [Tên của bạn]
    Ngày tạo: [Ngày hiện tại]
-->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('tasks.*') || request()->routeIs('categories.*') ? 'active' : '' }}" 
                       href="#" id="taskDropdown" role="button" data-bs-toggle="dropdown">
                        Công việc
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                                Danh sách công việc
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                Danh mục
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('tasks.calendar') ? 'active' : '' }}" href="{{ route('tasks.calendar') }}">
                                Lịch công việc
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('tasks.statistics') ? 'active' : '' }}" href="{{ route('tasks.statistics') }}">
                                Thống kê
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Hồ sơ
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
