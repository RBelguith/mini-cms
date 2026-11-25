<?php

use App\Models\Post;
use App\Models\Tag;

it('lists tags with their published post count', function () {
    $tag = Tag::factory()->create();
    Post::factory()->published()->count(2)->create()->each(
        fn (Post $post) => $post->tags()->attach($tag)
    );
    Post::factory()->create()->tags()->attach($tag);

    $this->getJson('/api/tags')
        ->assertOk()
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'slug', 'posts_count']],
        ])
        ->assertJsonPath('data.0.slug', $tag->slug)
        ->assertJsonPath('data.0.posts_count', 2);
});

it('filters posts by tag slug', function () {
    $tag = Tag::factory()->create();
    $tagged = Post::factory()->published()->create(['title' => 'Avec le tag']);
    $untagged = Post::factory()->published()->create(['title' => 'Sans le tag']);
    $tagged->tags()->attach($tag);

    $this->getJson('/api/posts?tag='.$tag->slug)
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $tagged->id)
        ->assertJsonPath('data.0.title', 'Avec le tag');

    expect($untagged->id)->not->toBe($tagged->id);
});

it('returns a JSON 404 for an unknown tag', function () {
    $this->getJson('/api/tags/999999')
        ->assertNotFound()
        ->assertJsonStructure(['message']);
});
