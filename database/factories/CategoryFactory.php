<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /** Catégories réelles du thème développement web. */
    private const NAMES = [
        'PHP',
        'Laravel',
        'JavaScript',
        'Base de données',
        'Front-end',
        'Back-end',
        'Sécurité',
        'Performance',
    ];

    /** Index cyclique : des noms distincts sans jamais épuiser la liste. */
    private static int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = self::NAMES[self::$index++ % count(self::NAMES)];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
