<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserWithCorrectCredentialsCanLogIn()
    {
        // Arrange.
        // Create a user and prep a login request.
        $user = factory(User::class)->create(['password' => bcrypt('pw1234')]);
        $user->createToken('Pixel 4');
        $data = [
            'device_name' => 'Pixel 4',
            'email'       => $user->email,
            'password'    => 'pw1234',
        ];

        // Act.
        // Attempt to log in.
        $response = $this->postJson('/api/login', $data);

        // Assert.
        // Ensure the user is logged in.
        $response->assertSuccessful();
        $this->assertNotNull($response->decodeResponseJson('data.token'));
    }

    public function testUserWithIncorrectCredentialsCannotLogIn()
    {
        // Arrange.
        // Create a user and prep a login request.
        $user = factory(User::class)->create(['password' => bcrypt('pw1234')]);
        $user->createToken('Pixel 4');
        $data = [
            'device_name' => 'Pixel 4',
            'email'       => $user->email,
            'password'    => "I don't know the password.",
        ];

        // Act.
        // Attempt to log in.
        $response = $this->postJson('/api/login', $data);

        // Assert.
        // Ensure the user is NOT logged in.
        $responseData = $response->decodeResponseJson();
        $response->assertStatus(422);
        $this->assertEquals('The given data was invalid.', $responseData['message']);
        $this->assertEquals('The provided credentials are incorrect.', Arr::get($responseData, 'errors.email.0'));
    }
}
