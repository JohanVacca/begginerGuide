<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creación del primer usuario y asignación del rol admin
        $user1 = User::create([
            'name' => 'Emiliano',
            'email' => 'emiliano_admin@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $user1->assignRole('admin');

        // Creación del segundo usuario y asignación del rol user
        $user2 = User::create([
            'name' => 'Pepito',
            'email' => 'pepito_usergeneral@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $user2->assignRole('user');
    }
}
