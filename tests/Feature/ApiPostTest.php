<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('lists only published posts with lightweight resource fields', function () {
    $author = User::factory()->create(['name' => 'Auteur API']);
    $category = Category::factory()->create(['name' => 'Laravel']);
    $tag = Tag::factory()->create(['name' => 'Tests']);
    $published = Post::factory()->published()->create([
        'user_id' => $author->id,
        'category_id' => $category->id,
    ]);
    $published->tags()->attach($tag);
    Post::factory()->create(['title' => 'Brouillon API']);

    $response = $this->getJson(route('api.posts.index'));

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [['id', 'title', 'slug', 'excerpt', 'published_at', 'author', 'category', 'tags', 'url']],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'per_page', 'to', 'total'],
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.author', 'Auteur API')
        ->assertJsonPath('data.0.category.name', 'Laravel')
        ->assertJsonPath('data.0.tags.0', 'Tests')
        ->assertJsonMissing(['body' => $published->body])
        ->assertJsonMissing(['email' => $author->email])
        ->assertJsonMissing(['role' => $author->role])
        ->assertJsonMissingPath('data.0.user_id');

    expect($response->json('data.0.published_at'))->toEndWith('+00:00');
});

it('keeps per_page in the pagination links', function () {
    Post::factory()->published()->count(3)->create();

    $response = $this->getJson(route('api.posts.index', ['per_page' => 2]));

    $response->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('meta.per_page', 2)
        ->assertJsonPath('links.next', route('api.posts.index', ['per_page' => 2, 'page' => 2]));
});

it('returns 422 when per_page is invalid', function (int|string $perPage) {
    $this->getJson(route('api.posts.index', ['per_page' => $perPage]))
        ->assertUnprocessable()
        ->assertJsonValidationErrors('per_page');
})->with([
    'above the maximum' => 500,
    'below the minimum' => 0,
    'not an integer' => 'abc',
]);

it('shows a published post with its body and tags', function () {
    $tag = Tag::factory()->create(['name' => 'API']);
    $post = Post::factory()->published()->create();
    $post->tags()->attach($tag);

    $this->getJson(route('api.posts.show', $post))
        ->assertOk()
        ->assertJsonPath('data.id', $post->id)
        ->assertJsonPath('data.body', $post->body)
        ->assertJsonPath('data.tags.0', 'API');
});

it('returns 404 for an unknown post', function () {
    $this->getJson('/api/posts/999999')
        ->assertNotFound()
        ->assertJsonStructure(['message']);
});

it('forbids a draft to a guest', function () {
    $post = Post::factory()->create(['is_published' => false]);

    $this->getJson(route('api.posts.show', $post))
        ->assertForbidden()
        ->assertJsonPath('message', 'This action is unauthorized.');
});

