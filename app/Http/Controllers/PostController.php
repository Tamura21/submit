<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Author;
use Illuminate\Http\Request;

class PostController extends Controller{
    /*** Display a listing of the resource.*/
    public function index(){
        $posts = Post::with('author')->get();
        return view('posts.index', compact('posts'));
    }

    /*** Show the form for creating a new resource.*/
    public function create(){
        $authors = Author::all();
        return view('posts.create', compact('authors'));
    }

    /*** Store a newly created resource in storage.*/
    public function store(Request $request){
        $request->validate([
            'author_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Post::create($request->all());
        return redirect()->route('posts.index'); 
    }

    /*** Display the specified resource.*/
    public function show(Post $post){
        $authors = Author::all();
        return view('posts.show', compact('post', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post){
        $request->validate([
            'author_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $post->update($request->all());
        return redirect()->route('posts.index');
    }

    /*** Remove the specified resource from storage.*/
    public function destroy(Post $post){
        $post->delete();
        return redirect()->route('posts.index');
    }
}