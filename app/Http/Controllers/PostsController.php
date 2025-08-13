<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest; 
use App\Models\Post;               
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return view('posts.index'); 
    }

    public function show()
    {
        $title = '詳細画面';
        return view('show', ['title' => $title]);
    }

    public function store(PostRequest $request) // PostRequest を型指定
    {
        
        $validated = $request->validated();

        Post::create($validated);

        return redirect()->route('posts.index')
                         ->with('success', '投稿を作成しました');
    }

    public function update(PostRequest $request, Post $post) // PostRequest を型指定
    {
        $validated = $request->validated();

        $post->update($validated);

        return redirect()->route('posts.index')
                         ->with('success', '投稿を更新しました');
    }
}