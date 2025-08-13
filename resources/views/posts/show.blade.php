<!DOCTYPE html>
<html>
<head>
    <title>投稿編集</title>
</head>
<body>
    <h1>編集画面</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">タイトル：</label><br>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}">
            @error('title')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="author_id">投稿者：</label><br>
            <select name="author_id" id="author_id">
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id', $post->author_id) == $author->id ? 'selected' : '' }}>
                        {{ $author->author_name }}
                    </option>
                @endforeach
            </select>
            @error('author_id')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="content">本文：</label><br>
            <textarea name="content" id="content" rows="5">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">更新</button>
        </div>
    </form>

    <br>
    <a href="{{ route('posts.index') }}">一覧へ戻る</a>
</body>
</html>