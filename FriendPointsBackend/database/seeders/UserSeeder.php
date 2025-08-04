<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createOne([
            "first_name" => "Ben",
            "last_name" => "Brown",
            "email" => "ben@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Matthew",
            "last_name" => "Kirk",
            "email" => "matthew@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Megan",
            "last_name" => "Brown",
            "email" => "megan@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Mia",
            "last_name" => "Beech",
            "email" => "mia@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Rachel",
            "last_name" => "Chambers",
            "email" => "rachel@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Jonny",
            "last_name" => "McConnell",
            "email" => "jonny@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Fergus",
            "last_name" => "Charnock",
            "email" => "fergus@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);

        User::factory()->createOne([
            "first_name" => "Louise",
            "last_name" => "Bradford",
            "email" => "louise@gmail.com",
            "email_verified_at" => now(),
            "password" => "Password",
        ]);
    }
}
