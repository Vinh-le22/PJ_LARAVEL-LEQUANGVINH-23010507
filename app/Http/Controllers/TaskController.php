<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Hiển thị danh sách công việc
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // Chỉ lấy công việc của user hiện tại
        $query->where('user_id', $request->user()->id);

        // Lọc theo trạng thái
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo danh mục
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Sắp xếp theo thời hạn
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'due_date_asc':
                    $query->orderBy('due_date', 'asc');
                    break;
                case 'due_date_desc':
                    $query->orderBy('due_date', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $tasks = $query->with('category')->get();
        $stats = $this->getTaskStats($request->user()->id);

        return view('tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Lấy thống kê công việc
     */
    private function getTaskStats($userId)
    {
        return [
            'total' => Task::where('user_id', $userId)->count(),
            'pending' => Task::where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress' => Task::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'completed' => Task::where('user_id', $userId)->where('status', 'completed')->count(),
            'overdue' => Task::where('user_id', $userId)->where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count()
        ];
    }

    /**
     * Hiển thị form tạo công việc mới
     */
    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('tasks.create', compact('categories'));
    }

    /**
     * Lưu công việc mới vào database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id'
        ]);
        $validated['user_id'] = $request->user()->id;
        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Công việc đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa công việc
     */
    public function edit(Task $task)
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('tasks.edit', compact('task', 'categories'));
    }

    /**
     * Cập nhật thông tin công việc
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Công việc đã được cập nhật thành công.');
    }

    /**
     * Xóa công việc
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Công việc đã được xóa thành công.');
    }
    
    /**
     * Hiển thị lịch công việc
     */
    public function calendar(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)
            ->whereNotNull('due_date')
            ->with('category')
            ->get();
            
        $events = $tasks->map(function($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'start' => $task->due_date->format('Y-m-d'),
                'backgroundColor' => $task->category ? $task->category->color : '#3788d8',
                'borderColor' => $task->category ? $task->category->color : '#3788d8',
                'textColor' => '#ffffff',
                'categoryName' => $task->category ? $task->category->name : '',
                'categoryColor' => $task->category ? $task->category->color : '#3788d8',
                'status' => $task->status
            ];
        });
        
        return view('tasks.calendar', compact('events'));
    }
    
    /**
     * Hiển thị thống kê công việc
     */
    public function statistics(Request $request)
    {
        $userId = $request->user()->id;
        $stats = $this->getTaskStats($userId);
        
        // Thống kê theo ngày (7 ngày gần nhất)
        $daily = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d/m'),
                    'count' => $item->count
                ];
            });
            
        // Thống kê theo tuần (8 tuần gần nhất)
        $weekly = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('updated_at', '>=', Carbon::now()->subWeeks(8))
            ->select(DB::raw('WEEK(updated_at) as week'), DB::raw('count(*) as count'))
            ->groupBy('week')
            ->orderBy('week')
            ->get();
            
        // Thống kê theo tháng (6 tháng gần nhất)
        $monthly = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('updated_at', '>=', Carbon::now()->subMonths(6))
            ->select(DB::raw('MONTH(updated_at) as month_num'), DB::raw('YEAR(updated_at) as year'), DB::raw('count(*) as count'))
            ->groupBy('month_num', 'year')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get()
            ->map(function($item) {
                $monthNames = [
                    1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3', 4 => 'Tháng 4', 5 => 'Tháng 5', 6 => 'Tháng 6',
                    7 => 'Tháng 7', 8 => 'Tháng 8', 9 => 'Tháng 9', 10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12'
                ];
                return [
                    'month' => $monthNames[$item->month_num] . '/' . $item->year,
                    'count' => $item->count
                ];
            });
            
        // Thống kê theo danh mục
        $categories = Category::where('user_id', $userId)
            ->withCount('tasks')
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->tasks_count,
                    'color' => $category->color
                ];
            });
            
        // Tính hiệu suất (tỷ lệ hoàn thành đúng hạn)
        $completedOnTime = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->where(function($query) {
                $query->whereNull('due_date')
                    ->orWhereRaw('DATE(updated_at) <= due_date');
            })
            ->count();
            
        $completedLate = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereNotNull('due_date')
            ->whereRaw('DATE(updated_at) > due_date')
            ->count();
            
        $totalCompleted = $completedOnTime + $completedLate;
        $performanceRate = $totalCompleted > 0 ? ($completedOnTime / $totalCompleted) * 100 : 0;
        
        $stats['daily'] = $daily;
        $stats['weekly'] = $weekly;
        $stats['monthly'] = $monthly;
        $stats['categories'] = $categories;
        $stats['completed_on_time'] = $completedOnTime;
        $stats['completed_late'] = $completedLate;
        $stats['performance_rate'] = $performanceRate;
        
        return view('tasks.statistics', compact('stats'));
    }
    
    /**
     * Cập nhật ngày cho công việc (AJAX cho tính năng kéo thả trong lịch)
     */
    public function updateDate(Request $request, Task $task)
    {
        // Kiểm tra quyền sở hữu
        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        // Cập nhật ngày
        $task->due_date = $request->due_date;
        $task->save();
        
        return response()->json(['success' => true]);
    }
}
