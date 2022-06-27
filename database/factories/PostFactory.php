<?php

namespace Database\Factories;

use App\Models\Category;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'title' => 'string',
        'content' => 'string',
        'summary' => 'string',
        'category_id' => 'int',
        'user_id' => 'int',
        'featured' => 'bool',
        'state' => 'string',
        'schedule_at' => DateTime::class,
        'archived_at' => DateTime::class,
        'published_at' => DateTime::class,
        'created_at' => DateTime::class,
        'updated_at' => DateTime::class,
    ])]
    public function definition(): array
    {
        $categories = Category::where('parent_id', '!=', null)->pluck('id')->toArray();

        return [
            'title' => $this->faker->words(12, true),
            'content' => $this->faker->paragraphs(5, true),
            'summary' => $this->faker->sentences(3, true),
            'category_id' => $this->faker->randomElement($categories),
            'user_id' => $this->faker->numberBetween(1, 19),
            'featured' => $this->faker->boolean(),
            'state' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'schedule_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'archived_at' => $this->faker->dateTimeBetween('-2 months', '+1 week'),
            'published_at' => $this->faker->dateTimeBetween('-5 years', '+2 months'),
            'created_at' => $this->faker->dateTimeBetween('-5 years', '+2 months'),
            'updated_at' => $this->faker->dateTimeBetween('-5 years', '+2 months'),
        ];
    }
}
