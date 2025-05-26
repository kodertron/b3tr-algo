<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plan;
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

        Plan::create([
            "name" => "monthly",
            "prev_price" => 65,
            "price" => 29.99,
            "image" => "trading.webp",
            "month_count" => 1,
        ]);

        Plan::create([
            "name" => "quaterly",
            "prev_price" => 125,
            "price" => 81.99,
            "image" => 'trading2.webp',
            "month_count" => 3
        ]);

        Plan::create([
            "name" => "yearly",
            "prev_price" => 425,
            "price" => 329.99,
            "image" => "trading-cube.png",
            "month_count" => 12
        ]);
    }
}
