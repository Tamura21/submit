<!DOCTYPE html>
<html>
<head>
    <title>新規投稿</title>
</head>
<body>
    <h1>新規登録画面</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div>
            <label for="title">タイトル：</label><br>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="author_id">投稿者：</label><br>
            <select name="author_id" id="author_id">
                <option value="" disabled {{ old('author_id') ? '' : 'selected' }}>選択してください</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->author_name }}
                    </option>
                @endforeach
                <option value="9991" {{ old('author_id') == 9991 ? 'selected' : '' }}>田中一郎</option>
                <option value="9992" {{ old('author_id') == 9992 ? 'selected' : '' }}>田中二郎</option>
            </select>
            @error('author_id')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="content">本文：</label><br>
            <textarea name="content" id="content" rows="5">{{ old('content') }}</textarea>
            @error('content')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">送信</button>
        </div>
    </form>

    <br>
    <a href="{{ route('posts.index') }}">一覧へ戻る</a>
</body>
</html>