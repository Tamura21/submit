<!DOCTYPE html>
<html>
<head>
    <title>Index Page</title>
</head>
<body>
    <h1>一覧画面</h1>
    <a href="{{ route('posts.create') }}">新規登録画面へ</a>
    <table border="1">
        <tr>
            <th>ID</th><th>著者</th><th>タイトル</th><th>操作</th>
        </tr>

    @foreach ($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->author?->author_name ?? '不明' }}</td>
            <td>{{ $post->title }}</td>
            <td>
            <a href="{{ route('posts.show', $post) }}">
                <button>編集</button>
            </a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">削除</button>
            </form>
            </td>
        </tr>
    @endforeach
    </table>
</body>
</html>