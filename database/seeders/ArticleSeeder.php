<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        DB::table('articles')->insert([
            [
                'title' => 'Top 10 Running Shoes of 2025',
                'description' => 'A rundown of the best running shoes for comfort, durability, and speed.',
                'filename' => 'aset_article1.png',
            ],
            [
                'title' => 'How to Choose the Right Sport Shoes',
                'description' => 'A guide to finding the perfect pair based on activity and foot type.',
                'filename' => 'aset_article2.png',
            ],
            [
                'title' => 'Basketball Shoes: Performance vs Style',
                'description' => 'Exploring the balance between functionality and aesthetics on the court.',
                'filename' => 'aset_article3.png',
            ],
            [
                'title' => 'Best Shoes for Gym Workouts',
                'description' => 'From weightlifting to cardio, here are the top gym shoes in 2025.',
                'filename' => 'aset_article4.png',
            ],
            [
                'title' => 'Kids’ Sport Shoes: What to Look For',
                'description' => 'Tips for picking sport shoes that support your child’s active lifestyle.',
                'filename' => 'aset_article5.png',
            ],
            [
                'title' => 'Shoe Technology Innovations',
                'description' => 'Discover the latest tech upgrades in modern sport shoes.',
                'filename' => 'aset_article6.png',
            ],
            [
                'title' => 'How Often Should You Replace Your Running Shoes?',
                'description' => 'Signs that your shoes are worn out and tips for replacement.',
                'filename' => 'aset_article7.png',
            ],
            [
                'title' => 'Top Picks for Trail Running Shoes',
                'description' => 'Our favorites for handling rough terrain and keeping you steady.',
                'filename' => 'aset_article8.png',
            ],
            [
                'title' => 'Sport Shoes Cleaning & Maintenance Tips',
                'description' => 'Make your favorite pair last longer with these care routines.',
                'filename' => 'aset_article9.png',
            ],
        ]);
    }
}
