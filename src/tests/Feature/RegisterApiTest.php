<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Normal
     * @test
     */
    public function should_新しいユーザーを作成して返却する()
    {
        $data = [
            'name' => 'vuesplash user',
            'email' => 'dummy@email.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
            'termsOfService' => User::AGREE_TO_TERMS_OF_SERVICE,
            'privacyPolicy' => User::AGREE_TO_PRIVACY_POLICY,
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);

        $response
            ->assertStatus(201)
            ->assertJson(['name' => $user->name])
            ->assertJson(['email' => $user->email]);
    }

    /**
     * Semi-normal
     * @test
     */
    public function should_正しいバリデーションエラーメッセージが返ってくる()
    {
        // Empty parameters
        $data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'termsOfService' => '',
            'privacyPolicy' => '',
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $this->assertNull($user);

        $response->assertStatus(422);

        $errors = $response->json()['errors'];
        $this->assertSame(array_shift($errors['name']), '「お名前」フィールドの入力は必須です。');
        $this->assertSame(array_shift($errors['email']), '「メールアドレス」フィールドの入力は必須です。');
        $this->assertSame(array_shift($errors['password']), '「パスワード」フィールドの入力は必須です。');
        $this->assertSame(array_shift($errors['termsOfService']), '「利用規約」に同意していただく必要があります。');
        $this->assertSame(array_shift($errors['privacyPolicy']), '「プライバシポリシー」に同意していただく必要があります。');

        // Incorrect parameters for terms
        $data = [
            'name' => 'vuesplash user',
            'email' => 'dummy@email.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
            'termsOfService' => 0,
            'privacyPolicy' => 0,
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $this->assertNull($user);

        $response->assertStatus(422);

        $errors = $response->json()['errors'];
        $this->assertSame(array_shift($errors['termsOfService']), '「利用規約」に同意していただく必要があります。');
        $this->assertSame(array_shift($errors['privacyPolicy']), '「プライバシポリシー」に同意していただく必要があります。');
    }
}
