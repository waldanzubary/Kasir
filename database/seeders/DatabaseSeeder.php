<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'password' => '12345678', // set a password for this user
            'role' => 'Admin', // if you want this user to have a specific role
            'city' => 'Jakarta',
            'address' => 'ADMIN',
            'phone' => '1234567890',
            'shop_name' => 'ADMIN',
            'zip_code' => 'ADMIN',
            'status' => 'active',
        ]);

        User::factory()->create([
            'username' => 'Mirza',
            'email' => 'mirzazubari83@gmail.com',
            'password' => '12345678', // set a password for this user
            'role' => 'User', // if you want this user to have a specific role
            'city' => 'Jakarta',
            'address' => 'Legenda Wisata Vivaldi',
            'phone' => '0864162442',
            'shop_name' => 'SEDAP MANTAP',
            'zip_code' => '16965',
            'status' => 'inactive',
        ]);
    }
}
