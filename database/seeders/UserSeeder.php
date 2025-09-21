<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => "admin123",
            'cpf' => "12345678999",
            'active' => true,
        ]);
    }
}
