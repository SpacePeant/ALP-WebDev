<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('articles')->insert([
            [
                'title' => 'Top 10 Running Shoes of 2025',
                'description' => 'A rundown of the best running shoes for comfort, durability, and speed.',
                'filename' => 'aset_article1.png',
                'article' => 'In 2025, the world of running shoes has seen tremendous innovation. From enhanced cushioning systems to breathable recycled materials, brands like Nike, Adidas, and Asics are pushing the boundaries. Our top 10 list includes models tested for long-distance comfort, ankle support, and shock absorption. Runners from all skill levels will find a shoe that fits both their stride and their style.'
            ],
            [
                'title' => 'How to Choose the Right Sport Shoes',
                'description' => 'A guide to finding the perfect pair based on activity and foot type.',
                'filename' => 'aset_article2.png',
                'article' => 'Choosing the right sport shoes depends on understanding your foot type and activity level. Flat feet, high arches, or overpronation all require different support. Additionally, shoes for running, basketball, and gym use vary in design. This article walks you through analyzing your foot shape, choosing proper cushioning, and even trying out gait analysis to find the ideal pair.'
            ],
            [
                'title' => 'Basketball Shoes: Performance vs Style',
                'description' => 'Exploring the balance between functionality and aesthetics on the court.',
                'filename' => 'aset_article3.png',
                'article' => 'Basketball shoes are no longer just performance gear—they\'re fashion statements. While high-tops offer better ankle protection, many players are opting for low-cut styles to boost agility. We examine whether style compromises court performance and which brands are successfully combining both elements in their 2025 models.'
            ],
            [
                'title' => 'Best Shoes for Gym Workouts',
                'description' => 'From weightlifting to cardio, here are the top gym shoes in 2025.',
                'filename' => 'aset_article4.png',
                'article' => 'Your gym workout shoes need to handle diverse demands: from lifting heavy weights to sprinting on the treadmill. In this article, we rate the best gym shoes for stability, grip, and breathability. We also include expert advice on sole thickness for lifting and lateral support for high-intensity interval training (HIIT).'
            ],
            [
                'title' => 'Kids’ Sport Shoes: What to Look For',
                'description' => 'Tips for picking sport shoes that support your child’s active lifestyle.',
                'filename' => 'aset_article5.png',
                'article' => 'Kids need shoes that support growing feet, resist wear and tear, and offer excellent cushioning. This guide breaks down shoe selection by age group and activity. Whether for school sports or playground play, we highlight features like flexible midsoles, easy laces, and washable materials that parents and kids both love.'
            ],
            [
                'title' => 'Shoe Technology Innovations',
                'description' => 'Discover the latest tech upgrades in modern sport shoes.',
                'filename' => 'aset_article6.png',
                'article' => 'From smart insoles that track your running form to graphene-enhanced soles, 2025 is an exciting year for shoe technology. We explore the most groundbreaking innovations and how they enhance comfort, reduce injury, and provide performance analytics to elevate your training.'
            ],
            [
                'title' => 'How Often Should You Replace Your Running Shoes?',
                'description' => 'Signs that your shoes are worn out and tips for replacement.',
                'filename' => 'aset_article7.png',
                'article' => 'Most running shoes need to be replaced every 300 to 500 miles. Worn-out treads, midsole compression, and discomfort are all signs that your shoes are due for retirement. This article offers tips on tracking mileage, evaluating shoe wear, and choosing your next pair based on how you run.'
            ],
            [
                'title' => 'Top Picks for Trail Running Shoes',
                'description' => 'Our favorites for handling rough terrain and keeping you steady.',
                'filename' => 'aset_article8.png',
                'article' => 'Trail running shoes need to tackle mud, gravel, and rocky inclines. We tested the latest models for grip, durability, and water resistance. Our top picks include both minimalist and rugged options, ensuring every type of trail runner can find their match for the wild outdoors.'
            ],
            [
                'title' => 'Sport Shoes Cleaning & Maintenance Tips',
                'description' => 'Make your favorite pair last longer with these care routines.',
                'filename' => 'aset_article9.png',
                'article' => 'Proper cleaning and maintenance can extend the life of your sport shoes by months. We share expert-approved methods for removing stains, drying shoes properly, and deodorizing them. Plus, learn when machine washing is safe—and when it could ruin your investment.'
            ],
        ]);
    }
}
