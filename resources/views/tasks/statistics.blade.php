@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Thống kê công việc</span>
                    <div>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">Danh sách công việc</a>
                        <a href="{{ route('tasks.calendar') }}" class="btn btn-sm btn-info">Lịch công việc</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Tổng số công việc</h5>
                                    <h2 class="mb-0">{{ $stats['total'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Đang chờ</h5>
                                    <h2 class="mb-0">{{ $stats['pending'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Đang thực hiện</h5>
                                    <h2 class="mb-0">{{ $stats['in_progress'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Hoàn thành</h5>
                                    <h2 class="mb-0">{{ $stats['completed'] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Hiệu suất công việc</div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="position-relative" style="width: 200px; height: 200px;">
                                            <canvas id="performanceChart"></canvas>
                                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                                <h3 class="mb-0">{{ number_format($stats['performance_rate'], 1) }}%</h3>
                                                <small>Hiệu suất</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="me-3">
                                                <span class="badge bg-success">&nbsp;</span> Đúng hạn: {{ $stats['completed_on_time'] }}
                                            </div>
                                            <div>
                                                <span class="badge bg-danger">&nbsp;</span> Trễ hạn: {{ $stats['completed_late'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Công việc theo danh mục</div>
                                <div class="card-body">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Công việc hoàn thành theo thời gian</div>
                                <div class="card-body">
                                    <div class="btn-group mb-3" role="group">
                                        <button type="button" class="btn btn-outline-primary active" id="daily-btn">Theo ngày</button>
                                        <button type="button" class="btn btn-outline-primary" id="weekly-btn">Theo tuần</button>
                                        <button type="button" class="btn btn-outline-primary" id="monthly-btn">Theo tháng</button>
                                    </div>
                                    <div id="daily-chart-container">
                                        <canvas id="dailyCompletionChart"></canvas>
                                    </div>
                                    <div id="weekly-chart-container" style="display: none;">
                                        <canvas id="weeklyCompletionChart"></canvas>
                                    </div>
                                    <div id="monthly-chart-container" style="display: none;">
                                        <canvas id="monthlyCompletionChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Biểu đồ hiệu suất
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceRate = {{ $stats['performance_rate'] }};
        const performanceChart = new Chart(performanceCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [performanceRate, 100 - performanceRate],
                    backgroundColor: ['#28a745', '#f8f9fa'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });

        // Biểu đồ danh mục
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = {!! json_encode($stats['categories']) !!};
        const categoryLabels = categoryData.map(item => item.name);
        const categoryValues = categoryData.map(item => item.count);
        const categoryColors = categoryData.map(item => item.color);
        
        const categoryChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Số công việc',
                    data: categoryValues,
                    backgroundColor: categoryColors,
                    borderColor: categoryColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Biểu đồ hoàn thành theo ngày
        const dailyData = {!! json_encode($stats['daily']) !!};
        const dailyCtx = document.getElementById('dailyCompletionChart').getContext('2d');
        const dailyChart = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyData.map(item => item.date),
                datasets: [{
                    label: 'Công việc hoàn thành',
                    data: dailyData.map(item => item.count),
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: '#28a745',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Biểu đồ hoàn thành theo tuần
        const weeklyData = {!! json_encode($stats['weekly']) !!};
        const weeklyCtx = document.getElementById('weeklyCompletionChart').getContext('2d');
        const weeklyChart = new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: weeklyData.map(item => `Tuần ${item.week}`),
                datasets: [{
                    label: 'Công việc hoàn thành',
                    data: weeklyData.map(item => item.count),
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: '#007bff',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Biểu đồ hoàn thành theo tháng
        const monthlyData = {!! json_encode($stats['monthly']) !!};
        const monthlyCtx = document.getElementById('monthlyCompletionChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: 'Công việc hoàn thành',
                    data: monthlyData.map(item => item.count),
                    backgroundColor: 'rgba(111, 66, 193, 0.2)',
                    borderColor: '#6f42c1',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Xử lý nút chuyển đổi biểu đồ
        document.getElementById('daily-btn').addEventListener('click', function() {
            document.getElementById('daily-chart-container').style.display = 'block';
            document.getElementById('weekly-chart-container').style.display = 'none';
            document.getElementById('monthly-chart-container').style.display = 'none';
            document.getElementById('daily-btn').classList.add('active');
            document.getElementById('weekly-btn').classList.remove('active');
            document.getElementById('monthly-btn').classList.remove('active');
        });

        document.getElementById('weekly-btn').addEventListener('click', function() {
            document.getElementById('daily-chart-container').style.display = 'none';
            document.getElementById('weekly-chart-container').style.display = 'block';
            document.getElementById('monthly-chart-container').style.display = 'none';
            document.getElementById('daily-btn').classList.remove('active');
            document.getElementById('weekly-btn').classList.add('active');
            document.getElementById('monthly-btn').classList.remove('active');
        });

        document.getElementById('monthly-btn').addEventListener('click', function() {
            document.getElementById('daily-chart-container').style.display = 'none';
            document.getElementById('weekly-chart-container').style.display = 'none';
            document.getElementById('monthly-chart-container').style.display = 'block';
            document.getElementById('daily-btn').classList.remove('active');
            document.getElementById('weekly-btn').classList.remove('active');
            document.getElementById('monthly-btn').classList.add('active');
        });
    });
</script>
@endsection