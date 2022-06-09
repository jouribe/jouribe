<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::create([
            'name' => 'Tag 1',
        ]);

        Tag::create([
            'name' => 'Tag 2',
        ]);

        Tag::create([
            'name' => 'Tag 3',
        ]);

        Tag::create([
            'name' => 'Tag 4',
        ]);

        Tag::create([
            'name' => 'Tag 5',
        ]);
    }
}
