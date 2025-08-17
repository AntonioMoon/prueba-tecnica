<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Usiuario Demo',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
