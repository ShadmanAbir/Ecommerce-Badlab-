<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@badlabco.com'],
            [
                'name' => 'BAD LAB Admin',
                'phone' => '01700000000',
                'password' => Hash::make('BadLab@2024'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@badlabco.com');
        $this->command->info('Password: BadLab@2024');
    }
}
