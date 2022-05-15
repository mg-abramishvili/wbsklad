<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.net',
                'password' => '$2y$10$qBDXLtZr5/QqonC5kW4vYe8kI5eGuBJz8ZOVMvahIQg4cdyXjidRG',
                'uid' => Str::random(12),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ],
        ]);

        DB::table('settings')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'wb_api_key' => 'ODE5NTA1ZjItNDJkYi00NGM0LWJkZjMtYTg4NGZhMzFjMzU0',
            ],
        ]);
    }
}