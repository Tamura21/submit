<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function Q01_ユーザー新規登録が成功する()
    {
        $data = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $data);

        // DBにユーザーが保存されていることを確認
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        // 登録後は /dashboard にリダイレクト
        $response->assertRedirect('/dashboard');

        // ユーザーがログイン状態になっていること
        $this->assertAuthenticated();
    }
}