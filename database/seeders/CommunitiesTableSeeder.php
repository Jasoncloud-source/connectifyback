<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('communities')->insert([
            [
                'name' => 'Hiking Enthusiasts',
                'description' => 'For people who love hiking.',
                'image' => 'hiking.jpg',
                'popularity_score' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Book Lovers',
                'description' => 'A community for bookworms.',
                'image' => 'books.jpg',
                'popularity_score' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fitness Freaks',
                'description' => 'Stay fit and active together.',
                'image' => 'fitness.jpg',
                'popularity_score' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}