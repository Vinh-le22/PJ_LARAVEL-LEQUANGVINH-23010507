<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bảng điều khiển') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Xin chào, {{ Auth::user()->name }}!</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Chào mừng bạn đến với ứng dụng Quản lý công việc cá nhân.
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Thống kê công việc -->
                        <div class="bg-indigo-50 overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Tổng số công việc
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                {{ \App\Models\Task::count() }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Công việc đang thực hiện -->
                        <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Đang thực hiện
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                {{ \App\Models\Task::where('status', 'in_progress')->count() }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Công việc đã hoàn thành -->
                        <div class="bg-yellow-50 overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Đã hoàn thành
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                {{ \App\Models\Task::where('status', 'completed')->count() }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('tasks.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-400 border border-blue-700 rounded-md font-semibold text-base text-black hover:bg-blue-600 hover:text-white transition">
                            ➕ Tạo công việc mới
                        </a>
                        <a href="{{ route('tasks.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-gray-700 rounded-md font-semibold text-base text-black hover:bg-gray-600 hover:text-white transition">
                            📋 Xem danh sách công việc
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
