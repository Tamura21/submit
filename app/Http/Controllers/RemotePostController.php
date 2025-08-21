<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB; // ← 追加

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

            DB::beginTransaction(); // トランザクション開始

            $post = Post::create($validated);

            DB::commit(); // 正常終了 → DBに反映

            return response()->json([
                'message' => 'success post',
                'data'    => $post
            ]);
        } catch (Exception $e) {
            DB::rollBack(); // エラー時 → 元に戻す
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
