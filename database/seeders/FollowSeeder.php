<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('follows')->insert([
                'followee_id' => 1,
                'follower_id' => 2, 
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
    }
}
