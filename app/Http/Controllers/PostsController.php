<?php

namespace App\Http\Controllers;

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
}
