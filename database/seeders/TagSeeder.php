<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()->createMany([
            ['name' => 'Débutant', 'slug' => 'debutant'],
            ['name' => 'Tests', 'slug' => 'tests'],
            ['name' => 'Blade', 'slug' => 'blade'],
            ['name' => 'Eloquent', 'slug' => 'eloquent'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'Sécurité', 'slug' => 'securite'],
        ]);
    }
}
