<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class dummy_users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()->count(4)->create();
    }
}
