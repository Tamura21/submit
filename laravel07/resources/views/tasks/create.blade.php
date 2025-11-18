@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">タスク新規登録</h1>
            {{-- [1：戻るボタン] --}}
            <a href="{{ url()->previous() }}" class="btn-back inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ← 戻る
            </a>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            {{-- [2：タスク名] 必須項目 --}}
            <div class="mb-4">
                <label for="txtTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    タスク名 <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="txtTitle" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- [3：担当者] 必須項目 --}}
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
                    <option value="{{ Auth::id() }}" {{ old('user_id') == Auth::id() ? 'selected' : '' }}>
                        自分
                    </option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- [4：ステータス] 必須項目 --}}
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
                        <option value="{{ $value }}" {{ old('task_status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('task_status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- [5：備考] 任意項目 --}}
            <div class="mb-6">
                <label for="areaComment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    備考
                </label>
                <textarea 
                    name="comment" 
                    id="areaComment" 
                    rows="5" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- [6：登録ボタン] --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('tasks.index') }}" style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.75rem; font-weight: 600;">
                    キャンセル
                </a>
                <button 
                    type="submit" 
                    id="btnSubmit"
                    style="background-color: #4f46e5; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; font-size: 0.75rem; font-weight: 600;"
                >
                    登録
                </button>
            </div>
        </form>
    </div>
</div>
@endsection