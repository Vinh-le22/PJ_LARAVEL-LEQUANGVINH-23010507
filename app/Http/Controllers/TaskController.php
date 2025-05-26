<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Hiển thị danh sách công việc
     */
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
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
