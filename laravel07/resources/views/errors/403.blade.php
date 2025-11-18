@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">403 Forbidden</h1>
    <p class="mb-4">この操作を行う権限がありません。</p>

    <div class="flex gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>

        {{-- tasks.index が定義されていればそこへ。なければサイトルートへ --}}
        @if (\Illuminate\Support\Facades\Route::has('tasks.index'))
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">タスク一覧へ</a>
        @else
            <a href="{{ url('/') }}" class="btn btn-primary">ホームへ</a>
        @endif
    </div>
</div>
@endsection