<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General Discussion',
                'description' => 'General topics related to the school.',
                'icon' => 'fas fa-comments',
                'display_order' => 1,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'name' => 'Academic Queries',
                'description' => 'Questions and discussions about subjects, exams, and homework.',
                'icon' => 'fas fa-book',
                'display_order' => 2,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'name' => 'Sports & Activities',
                'description' => 'Updates and chats about sports teams and extracurricular activities.',
                'icon' => 'fas fa-futbol',
                'display_order' => 3,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'name' => 'Events & Announcements',
                'description' => 'Community discussions about upcoming events.',
                'icon' => 'fas fa-calendar-alt',
                'display_order' => 4,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'name' => 'Parent Corner',
                'description' => 'A space for parents to connect and discuss.',
                'icon' => 'fas fa-users',
                'display_order' => 5,
                'is_active' => true,
                'created_at' => now(),
            ],
        ];

        DB::table('forum_categories')->insert($categories);
    }
}
