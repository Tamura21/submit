@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">タスク編集</h1>
            {{-- [1：戻るボタン] --}}
            <a href="{{ url()->previous() }}" class="btn-back inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                ← 戻る
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- タスク名 --}}
            <div class="mb-4">
                <label for="txtTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    タスク名 <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="txtTitle" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    value="{{ old('title', $task->title) }}"
                    required
                    maxlength="255"
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 担当者 --}}
            <div class="mb-4">
                <label for="drpUserId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    担当者 <span class="text-red-500">*</span>
                </label>
                <select 
                    name="user_id" 
                    id="drpUserId" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required
                >
                    <option value="{{ Auth::id() }}" {{ old('user_id', $task->user_id) == Auth::id() ? 'selected' : '' }}>
                        自分
                    </option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- ステータス --}}
            <div class="mb-4">
                <label for="drpTaskStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    ステータス <span class="text-red-500">*</span>
                </label>
                <select 
                    name="task_status" 
                    id="drpTaskStatus" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required
                >
                    @foreach(config('tasks.status') as $value => $label)
                        <option value="{{ $value }}" {{ old('task_status', $task->task_status) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('task_status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 備考 --}}
            <div class="mb-6">
                <label for="areaComment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    備考
                </label>
                <textarea 
                    name="comment" 
                    id="areaComment" 
                    rows="5" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >{{ old('comment', $task->comment) }}</textarea>
                @error('comment')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 更新ボタン --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('tasks.index') }}" style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.75rem; font-weight: 600;">
                    キャンセル
                </a>
                <button 
                    type="submit" 
                    id="btnSubmit"
                    style="background-color: #4f46e5; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; font-size: 0.75rem; font-weight: 600;"
                >
                    更新
                </button>
            </div>
        </form>
    </div>
</div>
@endsection