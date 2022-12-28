<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Course;
use App\Models\Platform;
use App\Models\Review;
use App\Models\Series;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // create admin user
        User::create([
           'name' => 'Admin',
           'email' => 'admin@habib.me',
           'password' => bcrypt('password'),
            'type' => 1,
        ]);

        $series = [
            [
                'name' => 'PHP',
                'slug' => 'php',
                'image' => 'https://laravel-courses.com/storage/series/c9cb9b3c-4d8c-4df6-a7b7-54047ce907ad.png',
            ],
            [
                'name' => 'Alpine.js',
                'slug' => 'aplpinejs',
                'image' => 'https://laravel-courses.com/storage/series/fe7d56b4-906c-4970-8c69-25956acb3988.png',
            ],
            [
                'name' => 'Livewire',
                'slug' => 'livewire',
                'image' => 'https://laravel-courses.com/storage/series/4dfa5245-e2fc-4dfe-88c9-5f001a180da6.png',
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'image' => 'https://laravel-courses.com/storage/series/54e8baab-727e-4593-a78a-e0c22c569b61.png',
            ],
            [
                'name' => 'Vue.js',
                'slug' => 'vuejs',
                'image' => 'https://laravel-courses.com/storage/series/7d2e33b5-fcd0-4227-bce6-aa49b976bd7c.png',
            ],
            [
                'name' => 'Tailwindcss',
                'slug' => 'tailwindcss',
                'image' => 'https://laravel-courses.com/storage/series/e63d6d09-4af0-4a6d-9cee-2daf537afcc8.png',
            ]
        ];
        foreach ($series as $item) {
            Series::create([
                'name' => $item['name'],
                'image' => $item['image'],
                'slug' => $item['slug']
            ]);
        }

        $topics = ['Eloquent', 'Validation', 'Authentication', 'Testing', 'Refactoring'];

        foreach ($topics as $item) {
            $slug = strtolower(str_replace(' ', '_', $item));
            Topic::create([
                'name' => $item,
                'slug' => $slug
            ]);
        }

        $platforms = ['Laracasts', 'YouTube', 'Larajobs', 'Laravel New', 'Laravel Forum'];
        foreach ($platforms as $item) {
            $slug = strtolower(str_replace(' ', '_', $item));
            Platform::create([
                'name' => $item,
                'slug' => $slug
            ]);
        }

        Author::factory(10)->create();

        // crate at 50s user
        User::factory(50)->create();

        // create 100 courses
        Course::factory(100)->create();

        $courses = Course::all();
        foreach ($courses as $course){
            $topics = Topic::all()->random(rand(1, 5))->pluck('id')->toArray();
            $course->topics()->attach($topics);

            $authors = Author::all()->random(rand(1, 4))->pluck('id')->toArray();
            $course->authors()->attach($authors);

            $series = Series::all()->random(rand(1, 4))->pluck('id')->toArray();
            $course->series()->attach($series);
        }

        Review::factory(100)->create();

    }
}
