<?php

namespace Tests\Feature\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCommandCreatesUser(): void
    {
        $user = "User";
        $email = "user@example.com";

        $this->artisan('app:user:create', [
            'name' => $user,
            'email' => $email
        ])
            ->expectsOutput("Creating user {$user} with email {$email}")
            // ->expectsOutput("User created with password:")
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $user,
            'email' => $email
        ]);
    }

    // Test a name is required
    public function testCommandRequiresANameIsProvided(): void
    {
        $email = "user@example.com";

        $this->artisan("app:user:create {$email}")
            ->expectsOutput('You must provide the name and email address of the user.')
            ->assertFailed();

        $this->assertDatabaseMissing('users', [
            'email' => $email
        ]);
    }

    // Test an email address is required
    public function testCommandRequiresAnEmailIsProvided(): void
    {
        $user = "User";

        $this->artisan('app:user:create', [
            'name' => $user
        ])
            ->expectsOutput('You must provide the name and email address of the user.')
            ->assertFailed();

        $this->assertDatabaseMissing('users', [
            'name' => $user
        ]);
    }

    // Test that only valid email address structures are accepted
    public function testCommandRequiresAValidEmailAddress(): void
    {
        $user = "User";
        $email = "invalid-email";

        $this->artisan('app:user:create', [
            'name' => $user,
            'email' => $email
        ])
            ->expectsOutput('The email must be a valid email address.')
            ->assertFailed();

        $this->assertDatabaseMissing('users', [
            'name' => $user,
            'email' => $email
        ]);
    }

    // Test it fails if a user with the email address already exists
    public function testCommandFailsIfUserAlreadyExists(): void
    {
        $user = "User";
        $email = "user@example.com";

        User::factory()->create([
            'name' => $user,
            'email' => $email,
            'password' => 'password',
        ]);

        $this->artisan('app:user:create', [
            'name' => $user,
            'email' => $email
        ])
            ->expectsOutput('A user with that email address already exists.')
            ->assertFailed();
    }
}
