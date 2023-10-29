<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(100)->create()->each(function (Book $book) {
            $num_reviews = random_int(5, 30);
            Review::factory()->count($num_reviews)->for($book)->create();
        });
    }
}
