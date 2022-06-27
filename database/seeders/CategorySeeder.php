<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Frameworks', 'Languages', 'Techniques', 'Testing', 'Tooling'];
        $frameworks = ['AlpineJS', 'Inertia', 'Laravel', 'Laravel Livewire', 'Nuxt', 'React', 'Symfony', 'Vue', 'Tailwind'];
        $languages = ['C#', 'CSS', 'GraphQL', 'JavaScript', 'PHP', 'SQL', 'TypeScript'];
        $techniques = ['Authentication', 'Blade', 'Clean Code', 'Deployment', 'OOP', 'Queues', 'Workshops'];
        $testing = ['Cypress', 'PHPUnit'];
        $tooling = [
            'Billing', 'Docker', 'Git', 'Laravel Cashier', 'Laravel Forge', 'Laravel Mix', 'Laravel Packages', 'MySQL', 'Nova', 'PHPStorm', 'Redis', 'Sublime Text', 'Visual Studio Code', 'Webpack'
        ];

        foreach ($categories as $category) {
            $created = Category::create([
                'name' => $category,
            ]);

            $subcategories = match ($category) {
                'Frameworks' => $frameworks,
                'Languages' => $languages,
                'Techniques' => $techniques,
                'Testing' => $testing,
                'Tooling' => $tooling
            };

            foreach ($subcategories as $subcategory) {
                Category::create([
                    'name' => $subcategory,
                    'parent_id' => $created->id,
                ]);
            }
        }
    }
}
