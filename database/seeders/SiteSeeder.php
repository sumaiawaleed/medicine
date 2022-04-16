<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Feedback;
use App\Models\Setting;
use App\Models\Statistic;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run()
    {
        Setting::create([
            'title' => '{"en": "Med","ar": "ميد"}',
            'meta_title' => '{"en": "Med","ar": "ميد"}',
            'author' => '{"en": "Med","ar": "ميد"}',
            'facebook' => '',
            'twitter' => '',
            'linkedin' => '',
            'youtube' => '',
            'email' => 'app@gmail.com',
            'phone' => '777888999',
        ]);

        Category::create([
            'parent_id' => 0,
            'name' => '{"en": "category 1","ar": "النوع 1"}',
            'is_parent' => 1,
        ]);

        Category::create([
            'parent_id' => 0,
            'name' => '{"en": "category 2","ar": "النوع 2"}',
            'is_parent' => 1,
        ]);

        Category::create([
            'parent_id' => 1,
            'name' => '{"en": "category 1","ar": "النوع 1"}',
            'is_parent' => 0,
        ]);

        Category::create([
            'parent_id' => 1,
            'name' => '{"en": "category 2","ar": "النوع 2"}',
            'is_parent' => 0,
        ]);

        Category::create([
            'parent_id' => 2,
            'name' => '{"en": "category 1","ar": "النوع 1"}',
            'is_parent' => 0,
        ]);

        Category::create([
            'parent_id' => 2,
            'name' => '{"en": "category 2","ar": "النوع 2"}',
            'is_parent' => 0,
        ]);
    }
}
