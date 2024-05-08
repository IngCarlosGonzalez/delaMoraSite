<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create(
            [
                'name' => 'LORENZO',
                'email' => 'jesus_adame67@hotmail.com',
                'password' => Hash::make('loremora1967'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'profile_photo_path' => '',
                'is_active' => true,
                'is_admin' => true,
            ]
        )->assignRole('superusuario');
        $user2 = User::create(
            [
                'name' => 'USUARIO1',
                'email' => 'calin_mx@hotmail.com',
                'password' => Hash::make('secreta1'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'profile_photo_path' => '',
                'is_active' => true,
                'is_admin' => false,
            ]
        )->assignRole('usuariocomun');
    }
}
