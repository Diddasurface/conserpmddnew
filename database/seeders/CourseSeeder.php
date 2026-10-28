<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        CourseSection::firstOrCreate(['id' => 1]);

        // Import the three existing demonstration cards only into an empty catalog.
        if (Course::exists()) {
            return;
        }

        $cards = [
            ['title' => 'ISO 9001', 'description' => 'React Js long fact that a reader will be distracted by the readable.', 'image' => 'course-01.jpg', 'instructor' => 'Patrick', 'instructor_image' => 'avater-01.png', 'category' => 'Languages', 'lessons_count' => 20, 'students_count' => 40, 'reviews_count' => 15, 'price' => 60, 'original_price' => 120, 'badge_text' => '-50%'],
            ['title' => 'PHP Beginner + Advanced', 'description' => 'It is a long established fact that a reader will be distracted by the readable.', 'image' => 'course-02.jpg', 'instructor' => 'Angela', 'instructor_image' => 'avatar-02.png', 'category' => 'Development', 'lessons_count' => 12, 'students_count' => 50, 'reviews_count' => 15, 'price' => 60, 'original_price' => 120, 'badge_text' => '-40%'],
            ['title' => 'Angular Zero to Mastery', 'description' => 'Angular Js long fact that a reader will be distracted by the readable.', 'image' => 'course-03.jpg', 'instructor' => 'Slaughter', 'instructor_image' => 'avatar-03.png', 'category' => 'Languages', 'lessons_count' => 8, 'students_count' => 30, 'reviews_count' => 5, 'price' => 80, 'original_price' => 100, 'badge_text' => '-40%'],
        ];

        foreach ($cards as $index => $card) {
            foreach (['image', 'instructor_image'] as $field) {
                $source = public_path('images/'.$card[$field]);
                $destination = 'courses/demo/'.$card[$field];
                if (is_file($source)) {
                    Storage::disk('public')->put($destination, file_get_contents($source));
                    $card[$field] = $destination;
                } else {
                    $card[$field] = null;
                }
            }

            Course::create(array_merge($card, [
                'currency' => '$',
                'rating' => 5,
                'badge_caption' => 'Descuento',
                'button_text' => 'Solicitar información',
                'is_published' => true,
                'sort_order' => $index + 1,
            ]));
        }
    }
}
