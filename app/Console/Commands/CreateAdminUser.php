<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {--email=ali@smartdecorations.com} {--password=Ali2024}';
    protected $description = 'Create or update the admin user';

    public function handle(): void
    {
        $email = $this->option('email');
        $password = $this->option('password');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => bcrypt($password),
                'is_admin' => true,
            ]
        );

        $this->info("Admin user created: {$user->email}");
    }
}
