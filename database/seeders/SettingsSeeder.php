<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Default School Settings
        DB::table('school_settings')->insert([
            'school_name' => 'My School ERP',
            'school_address' => '123 Education Lane, Learning City',
            'school_phone' => '+1234567890',
            'school_email' => 'admin@school.com',
            'currency_symbol' => '₦',
            'currency_code' => 'NGN',
            'theme_color' => '#3B82F6', // Modern Blue
            'academic_year' => '2025-2026',
            'current_term' => 'First Term',
            'timezone' => 'Africa/Lagos',
            'date_format' => 'd M, Y',
            'social_links' => json_encode([
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'instagram' => 'https://instagram.com'
            ]),
        ]);

        // Default Theme
        DB::table('cms_themes')->insert([
            'name' => 'Default Theme',
            'directory' => 'default',
            'version' => '1.0.0',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Default Website Content
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'Welcome to My School',
                'subtitle' => 'Empowering the next generation of leaders.',
                'content' => 'We provide world-class education with state-of-the-art facilities.',
                'action_text' => 'Apply Now',
                'action_url' => '/admission',
                'display_order' => 1,
                'settings' => json_encode(['layout' => 'centered', 'show_overlay' => true]),
            ],
            [
                'section_key' => 'about',
                'title' => 'About Us',
                'content' => 'Founded in 2020, we strive for excellence in academics and character.',
                'display_order' => 2,
                'settings' => json_encode(['background_color' => '#f3f4f6']),
            ],
            [
                'section_key' => 'contact',
                'title' => 'Contact Us',
                'subtitle' => 'Get in touch',
                'display_order' => 3,
                'settings' => null,
            ]
        ];

        foreach ($sections as $section) {
            $section['created_at'] = now();
            $section['updated_at'] = now();
            DB::table('website_content')->insert($section);
        }
    }
}
