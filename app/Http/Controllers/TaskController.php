<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Hiển thị danh sách công việc
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // Lọc theo trạng thái
        if ($request->has('status')) {
            $query->where('status', $request->status);
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

        $tasks = $query->get();
        $stats = $this->getTaskStats();

        return view('tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Lấy thống kê công việc
     */
    private function getTaskStats()
    {
        return [
            'total' => Task::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count()
        ];
    }

    /**
     * Hiển thị form tạo công việc mới
     */
    public function create()
    {
        return view('tasks.create');
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
            'due_date' => 'nullable|date'
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Công việc đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa công việc
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
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
            'due_date' => 'nullable|date'
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
}
