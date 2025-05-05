<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Logo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create ONLY one admin user
        User::factory()->create([
            'profile' => 'images/default_profile.png',
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        User::factory()->create([
            'profile' => 'images/default_profile.png',
            'username' => 'honey.cabatingan',
            'password' => Hash::make('admin'),
        ]);

        User::factory()->create([
            'profile' => 'images/default_profile.png',
            'username' => 'dantmoise.tirol',
            'password' => Hash::make('admin'),
        ]);

        User::factory()->create([
            'profile' => 'images/default_profile.png',
            'username' => 'immanuel.zimmerman',
            'password' => Hash::make('admin'),
        ]);


        // Create default logos
        Logo::create([
            'key' => 'logo1',
            'value' => 'images/default1.png',
        ]);

        Logo::create([
            'key' => 'logo2',
            'value' => 'images/default2.png',
        ]);
    }
}
