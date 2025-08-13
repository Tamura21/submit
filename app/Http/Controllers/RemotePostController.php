<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;

class RemotePostController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'     => 'required|string|max:255',
                'author_id' => 'required|integer',
                'content'   => 'nullable|string|max:1000',
            ]);

            $post = Post::create($validated);

            return response()->json([
                'message' => 'success post',
                'data'    => $post
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}