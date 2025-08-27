<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /** 投稿一覧の表示 */
    public function index()
    {
        $posts = Post::with('author')->get();
        return view('posts.index', compact('posts'));
    }

    /** 新規投稿フォームの表示 */
    public function create()
    {
        $authors = Author::all();
        return view('posts.create', compact('authors'));
    }

    /** 投稿の保存処理 */
    public function store(Request $request)
    {
        $request->validate([
            'author_id' => 'required|integer',
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
        ]);

        Post::create($request->all());
        return redirect()->route('posts.index'); 
    }

    /** 投稿の詳細表示 */
    public function show(Post $post)
    {
        Log::info('[PostController@show] 詳細画面表示', ['post' => $post->toArray()]);
        $authors = Author::all();
        return view('posts.show', compact('post', 'authors'));
    }

    /** 投稿の編集フォーム表示 */
    public function edit(Post $post)
    {
        Log::info('[PostController@edit] 編集画面表示', ['post' => $post->toArray()]);
        $authors = Author::all();
        return view('posts.edit', compact('post', 'authors'));
    }

    /** 投稿の更新処理 */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'author_id' => 'required|integer',
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
        ]);

        $post->update($request->all());
        return redirect()->route('posts.index');
    }

    /** 投稿の削除処理 */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
