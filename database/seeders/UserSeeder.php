<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => "admin@gmail.com"],
            [
                'name' => "admin",
                'password' => "admin123",
                'cpf' => "12345678999",
                'active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => "user@gmail.com"],
            [
                'name' => "user",
                'password' => "user123",
                'cpf' => "22345678999",
                'active' => true,
            ]
        );
    }
}
