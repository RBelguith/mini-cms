<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /** Tags réels du thème développement web. */
    private const NAMES = [
        'Débutant',
        'Tests',
        'Blade',
        'Eloquent',
        'API',
        'Sécurité',
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
