<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KidKinderThemeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Register Theme
        $themeId = DB::table('cms_themes')->insertGetId([
            'name' => 'KidKinder',
            'directory' => 'kidkinder', // Must match folder name
            'version' => '1.0.0',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Deactivate other themes
        DB::table('cms_themes')->where('id', '!=', $themeId)->update(['is_active' => false]);

        // 2. Insert Content matching the Screenshot
        // Clear existing content for clean slate (optional, but safe for this requested task)
        DB::table('website_content')->truncate();

        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'New Approach to Kids Education',
                'subtitle' => 'Kids Learning Center',
                'content' => 'Sea ipsum kasd eirmod kasd magna, est sea et diam ipsum est amet sed sit. Ipsum dolor no justo dolor et, lorem ut dolor erat dolore sed ipsum at ipsum nonumy amet.',
                'action_text' => 'Learn More',
                'action_url' => '#about',
                'image_path' => 'https://images.unsplash.com/photo-1503919545839-9a87d7d105b3?q=80&w=2070&auto=format&fit=crop', // Child reading
                'display_order' => 1,
            ],
            [
                'section_key' => 'facilities',
                'title' => 'Play Ground',
                'content' => 'Kasd labore kasd et dolor est rebum dolor ut, clita dolor vero lorem amet elitr vero...',
                'display_order' => 2,
            ],
            [
                'section_key' => 'about',
                'title' => 'Best School For Your Kids',
                'subtitle' => 'Learn About Us',
                'content' => "Invidunt lorem justo sanctus clita. Erat lorem labore ea, justu labore lorem ipsum saet sed, ipsum et amet kasd sit.\n\nSanctus sit amset lorem amet elitr amet.\nClita at sit clita amet ipsum.\nSanctus dolor stet lorem amet elitr.",
                'image_path' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?q=80&w=2072&auto=format&fit=crop', // Kids on couch
                'action_text' => 'Read More',
                'display_order' => 3,
            ],
            [
                'section_key' => 'classes',
                'title' => 'Classes for Your Kids',
                'subtitle' => 'Popular Classes',
                'display_order' => 4,
            ],
            [
                'section_key' => 'registration',
                'title' => 'Book A Seat For Your Kid',
                'content' => 'Invidunt lorem justo sanctus clita. Erat lorem labore ea, justu labore lorem ipsum saet sed, ipsum et amet kasd sit.',
                'display_order' => 5,
            ]
        ];

        foreach ($sections as $section) {
            $section['is_active'] = true;
            $section['created_at'] = now();
            $section['updated_at'] = now();
            DB::table('website_content')->insert($section);
        }
    }
}
