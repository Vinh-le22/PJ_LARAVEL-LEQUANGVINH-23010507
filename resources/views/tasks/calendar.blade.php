@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Lịch công việc</span>
                    <div>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">Danh sách công việc</a>
                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">Thêm công việc</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" id="month-view-btn">Xem theo tháng</button>
                            <button type="button" class="btn btn-outline-primary" id="week-view-btn">Xem theo tuần</button>
                        </div>
                    </div>
                    
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>

<style>
    /* Cải thiện hiển thị sự kiện trong lịch */
    .fc-event {
        border-radius: 4px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24) !important;
        transition: all 0.3s cubic-bezier(.25,.8,.25,1) !important;
        margin-bottom: 2px !important;
    }
    
    .fc-event:hover {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important;
    }
    
    .fc-event-title {
        font-weight: bold !important;
        padding: 2px 0 !important;
    }
    
    /* Cải thiện hiển thị trên thiết bị di động */
    @media (max-width: 768px) {
        .fc-event-title {
            font-size: 0.9em !important;
        }
        
        .fc-event-status span {
            font-size: 0.9em !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            locale: 'vi',
            events: {!! json_encode($events) !!},
            eventClick: function(info) {
                window.location.href = '/tasks/' + info.event.id + '/edit';
            },
            eventDrop: function(info) {
                const taskId = info.event.id;
                // Lấy ngày mới và điều chỉnh múi giờ để tránh bị lệch ngày
                let newDate = new Date(info.event.start);
                // Đảm bảo sử dụng ngày đúng theo múi giờ địa phương
                newDate = new Date(newDate.getFullYear(), newDate.getMonth(), newDate.getDate());
                const formattedDate = newDate.toISOString().split('T')[0];
                const taskTitle = info.event.title;
                
                fetch(`/tasks/${taskId}/update-date`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ due_date: formattedDate })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hiển thị thông báo thành công
                        const toast = document.createElement('div');
                        toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
                        toast.style.top = '20px';
                        toast.style.right = '20px';
                        toast.style.zIndex = '9999';
                        toast.innerHTML = `
                            Công việc <strong>${taskTitle}</strong> đã được chuyển sang ngày ${new Date(formattedDate).toLocaleDateString('vi-VN')}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.body.appendChild(toast);
                        
                        // Tự động ẩn thông báo sau 3 giây
                        setTimeout(() => {
                            toast.classList.remove('show');
                            setTimeout(() => toast.remove(), 150);
                        }, 3000);
                    } else {
                        info.revert();
                        alert('Không thể cập nhật ngày cho công việc này.');
                    }
                })
                .catch(error => {
                    info.revert();
                    alert('Đã xảy ra lỗi khi cập nhật ngày.');
                });
            },
            editable: true,
            dayMaxEvents: true,
            eventContent: function(arg) {
                const categoryColor = arg.event.extendedProps.categoryColor || '#3788d8';
                const categoryName = arg.event.extendedProps.categoryName || '';
                const status = arg.event.extendedProps.status || 'pending';
                
                const eventContent = document.createElement('div');
                eventContent.classList.add('fc-event-main-content');
                eventContent.style.width = '100%';
                eventContent.style.padding = '4px';
                eventContent.style.display = 'flex';
                eventContent.style.flexDirection = 'column';
                eventContent.style.height = '100%';
                
                const title = document.createElement('div');
                title.classList.add('fc-event-title');
                title.innerHTML = arg.event.title;
                title.style.fontWeight = 'bold';
                title.style.marginBottom = '2px';
                title.style.fontSize = '1.1em';
                title.style.overflow = 'hidden';
                title.style.textOverflow = 'ellipsis';
                title.style.whiteSpace = 'normal';
                title.style.wordBreak = 'break-word';
                title.style.lineHeight = '1.2';
                title.style.maxHeight = '2.4em';
                title.style.display = '-webkit-box';
                title.style.webkitLineClamp = '2';
                title.style.webkitBoxOrient = 'vertical';
                
                // Thêm biểu tượng trạng thái
                let statusIcon = '';
                let statusText = '';
                switch(status) {
                    case 'completed':
                        statusIcon = '✓';
                        statusText = 'Hoàn thành';
                        break;
                    case 'in_progress':
                        statusIcon = '⟳';
                        statusText = 'Đang thực hiện';
                        break;
                    default:
                        statusIcon = '⏱';
                        statusText = 'Chờ xử lý';
                }
                
                const statusDiv = document.createElement('div');
                statusDiv.classList.add('fc-event-status');
                statusDiv.innerHTML = `<span title="${statusText}">${statusIcon}</span>`;
                statusDiv.style.fontSize = '1em';
                statusDiv.style.marginRight = '6px';
                statusDiv.style.display = 'inline-block';
                statusDiv.style.fontWeight = 'bold';
                
                const category = document.createElement('div');
                category.classList.add('fc-event-category');
                category.innerHTML = categoryName;
                category.style.fontSize = '0.85em';
                category.style.display = 'inline-block';
                category.style.backgroundColor = categoryColor + '40'; // Thêm độ trong suốt
                category.style.padding = '1px 4px';
                category.style.borderRadius = '3px';
                category.style.color = '#333';
                
                const infoDiv = document.createElement('div');
                infoDiv.style.display = 'flex';
                infoDiv.style.alignItems = 'center';
                infoDiv.style.marginTop = 'auto'; // Đẩy xuống dưới
                infoDiv.appendChild(statusDiv);
                
                if (categoryName) {
                    infoDiv.appendChild(category);
                }
                
                eventContent.appendChild(title);
                eventContent.appendChild(infoDiv);
                
                const eventEl = document.createElement('div');
                eventEl.classList.add('fc-event-custom');
                eventEl.style.borderLeft = `4px solid ${categoryColor}`;
                eventEl.style.backgroundColor = `${categoryColor}20`;
                eventEl.style.color = categoryColor;
                eventEl.style.padding = '2px';
                eventEl.appendChild(eventContent);
                
                return { domNodes: [eventEl] };
            }
        });
        
        calendar.render();
        
        // Xử lý nút chuyển đổi chế độ xem
        document.getElementById('month-view-btn').addEventListener('click', function() {
            calendar.changeView('dayGridMonth');
        });
        
        document.getElementById('week-view-btn').addEventListener('click', function() {
            calendar.changeView('timeGridWeek');
        });
    });
</script>

<style>
    .fc-event-custom {
        margin: 1px 0;
        border-radius: 3px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .fc-event-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .fc-day-today {
        background-color: rgba(255, 220, 240, 0.15) !important;
    }
    
    .fc-event-time {
        display: none;
    }
    
    .fc-event-title {
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .fc-event-status {
        margin-right: 4px;
    }
    
    /* Thêm tooltip cho trạng thái */
    [title] {
        position: relative;
        cursor: help;
    }
    
    /* Responsive cho màn hình nhỏ */
    @media (max-width: 768px) {
        .fc-header-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .fc-toolbar-chunk {
            margin-bottom: 10px;
        }
    }
</style>
@endsection