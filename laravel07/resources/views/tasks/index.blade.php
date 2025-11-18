@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        
        {{-- ユーザー情報表示エリア --}}
        <div class="flex items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            {{-- [1：ユーザーアイコン] --}}
            <div class="mr-4">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール画像" class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
            </div>
            {{-- [2：ユーザー名] --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">タスク一覧</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- 検索・フィルターフォーム --}}
<form action="{{ route('tasks.index') }}" method="GET" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        {{-- [3：フリーワード検索] --}}
        <div>
            <label for="txtKeyword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                フリーワード検索
            </label>
            <input
                type="text"
                name="keyword"
                id="txtKeyword"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="タスク名、ID"
                value="{{ request('keyword') }}"
            >
        </div>

        {{-- [4：担当者セレクトボックス] --}}
        <div>
            <label for="drpUserId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                担当者
            </label>
            <select
                name="user_id"
                id="drpUserId"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >
                <option value="">担当者</option>
                <option value="{{ Auth::id() }}" {{ request('user_id') == Auth::id() ? 'selected' : '' }}>自分</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- [5：ステータスセレクトボックス] --}}
        <div>
            <label for="drpTaskStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                ステータス
            </label>
            <select
                name="task_status"
                id="drpTaskStatus"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >
                <option value="">すべて</option>
                @foreach(config('tasks.status') as $value => $label)
                    <option value="{{ $value }}" {{ request('task_status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- [6：絞り込みボタン] --}}
        <div class="flex justify-end">
            <button
              type="submit"
              id="btnSearch"
              style="background-color: #4f46e5; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem;"
              class="hover:bg-indigo-700 transition ease-in-out duration-150"
          >
              絞り込み
         </button>
        </div>

        @if($tasks->isEmpty())
            <p class="text-center text-gray-600 dark:text-gray-400 py-8">タスクはありません。</p>
        @else
            {{-- [7：テーブルヘッダー] ソート機能付き --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('tasks.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-white">
                                    ID
                                    @if(request('sort') === 'id')
                                        @if(request('direction') === 'asc')
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('tasks.index', array_merge(request()->all(), ['sort' => 'title', 'direction' => request('sort') === 'title' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-white">
                                    タスク名
                                    @if(request('sort') === 'title')
                                        @if(request('direction') === 'asc')
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('tasks.index', array_merge(request()->all(), ['sort' => 'task_status', 'direction' => request('sort') === 'task_status' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-white">
                                    ステータス
                                    @if(request('sort') === 'task_status')
                                        @if(request('direction') === 'asc')
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                担当者
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('tasks.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-white">
                                    作成日
                                    @if(request('sort') === 'created_at')
                                        @if(request('direction') === 'asc')
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                操作
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- [8：テーブル行] --}}
                        @foreach($tasks as $task)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $task->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $task->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($task->task_status == config('tasks.status_not_started')) bg-gray-100 text-gray-800
                                        @elseif($task->task_status == config('tasks.status_in_progress')) bg-blue-100 text-blue-800
                                        @elseif($task->task_status == config('tasks.status_on_hold')) bg-yellow-100 text-yellow-800
                                        @elseif($task->task_status == config('tasks.status_completed')) bg-green-100 text-green-800
                                        @endif">
                                        {{ config('tasks.status.' . $task->task_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ optional($task->user)->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $task->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        {{-- [9：編集ボタン] --}}
                                        @can('update', $task)
                                            <a 
                                                href="{{ route('tasks.edit', $task) }}" 
                                                id="btnEdit{{ $task->id }}" 
                                                style="background-color: #2563eb; color: white; padding: 0.5rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-block;"
                                                class="hover:bg-blue-700 transition"
                                            >
                                                編集
                                            </a>
                                        @endcan
                                        
                                        {{-- [10：削除ボタン] --}}
                                        @can('delete', $task)
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="button" 
                                                    id="btnDelete{{ $task->id }}" 
                                                    style="background-color: #dc2626; color: white; padding: 0.5rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; border: none; cursor: pointer;"
                                                    class="hover:bg-red-700 transition delete-button"
                                                >
                                                    削除
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $tasks->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

{{-- [10：削除確認モーダル] --}}
<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                            タスクの削除
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                このタスクを削除します。よろしいですか？
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    削除
                </button>
                <button type="button" id="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    キャンセル
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 削除確認モーダルのJavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const delete_buttons = document.querySelectorAll('.delete-button');
    const delete_modal = document.getElementById('deleteModal');
    const confirm_delete = document.getElementById('confirmDelete');
    const cancel_delete = document.getElementById('cancelDelete');
    let current_form = null;

    // 削除ボタンをクリックしたときの処理
    delete_buttons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            current_form = this.closest('form');
            delete_modal.classList.remove('hidden');
        });
    });

    // モーダルの「削除」ボタンをクリックしたときの処理
    confirm_delete.addEventListener('click', function () {
        if (current_form) {
            current_form.submit();
        }
    });

    // モーダルの「キャンセル」ボタンをクリックしたときの処理
    cancel_delete.addEventListener('click', function () {
        delete_modal.classList.add('hidden');
        current_form = null;
    });

    // モーダルの背景をクリックしたときの処理
    delete_modal.addEventListener('click', function (e) {
        if (e.target === delete_modal) {
            delete_modal.classList.add('hidden');
            current_form = null;
        }
    });
});
</script>
@endsection