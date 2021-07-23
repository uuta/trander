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
            'passwordConfirmation' => 'test1234',
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

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }
}
