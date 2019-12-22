<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordResetApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * パスワードリセットをリクエストする画面の閲覧可能
     */
    public function should_パスワードリセット画面にアクセスできる()
    {
        $response = $this->get('/reset-password');

        $response->assertStatus(200);
    }

    /**
     * @test
     * パスワードリセットのリクエスト成功
     */
    public function should_パスワードリセットのリクエストが成功する()
    {
        // ユーザーを1つ作成
        $user = factory(User::class)->create();

        // パスワードリセットをリクエスト
        $response = $this->from('/api/reset-password')->post('/api/reset-password', [
            'email' => $user->email,
        ]);

        // 同画面にリダイレクト
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Password reset email sent.',
                'data' => 'passwords.sent',
            ]);
    }
}
