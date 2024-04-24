<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    protected $signature = 'app:user:create
                            {name : The name of the user being created}
                            {email? : The email address of the user being created}';

    protected $description = 'Create a new application user';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        if (!$email) {
            $this->error('You must provide the name and email address of the user.');
            return 1;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('The email must be a valid email address.');
            return 2;
        } elseif (User::where('email', $email)->exists()) {
            $this->error('A user with that email address already exists.');
            return 3;
        }

        $this->info("Creating user {$name} with email {$email}");

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(
                $password = Str::random(16)
            ),
        ]);

        $this->info("User created with password: {$password}");
    }
}
