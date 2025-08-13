<?php

namespace App\Http\Requests;

use App\Http\Requests\PostRequest;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer',
            'content' => 'nullable|string|max:1000',
        ];
    }
}