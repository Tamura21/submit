<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * タスク一覧表示
     */
    public function index(Request $request)
    {
        $query = Task::with('user');

        // フリーワード検索（タスク名、ID）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('id', 'like', '%' . $keyword . '%');
            });
        }

        // 担当者フィルター
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // ステータスフィルター
        if ($request->filled('task_status')) {
            $query->where('task_status', $request->task_status);
        }

        // ソート機能
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        $allowed_sorts = ['id', 'title', 'task_status', 'created_at'];
        if (in_array($sort, $allowed_sorts)) {
            $query->orderBy($sort, $direction);
        }

        $tasks = $query->paginate(15);
        $users = \App\Models\User::all();

        return view('tasks.index', compact('tasks', 'users'));
    }

    /**
     * タスク新規登録フォーム表示
     */
    public function create()
    {
        $users = \App\Models\User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * タスク新規登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'task_status' => 'required|integer',
            'comment' => 'nullable|string',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました');
    }

    /**
     * タスク編集フォーム表示
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $users = \App\Models\User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * タスク更新処理
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'task_status' => 'required|integer',
            'comment' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました');
    }

    /**
     * タスク削除処理
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました');
    }
}