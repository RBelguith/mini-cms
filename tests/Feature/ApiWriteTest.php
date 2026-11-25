<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

function apiTokenFor(User $user, string $name = 'api'): string
{
    return $user->createToken($name)->plainTextToken;
}

it('issues a token with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'writer@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertCreated()
        ->assertJsonStructure(['token', 'token_type'])
        ->assertJsonPath('token_type', 'Bearer');

    $this->assertDatabaseCount('personal_access_tokens', 1);
});

it('rejects invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'writer@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertUnprocessable()->assertJsonValidationErrors('email');
});

it('returns the authenticated user', function () {
    $user = User::factory()->create();

    $this->withToken(apiTokenFor($user))
        ->getJson('/api/user')
        ->assertOk()
        ->assertJsonPath('id', $user->id)
        ->assertJsonPath('email', $user->email);
});

it('revokes only the current token on logout', function () {
    $user = User::factory()->create();
    $first = apiTokenFor($user, 'first');
    $second = apiTokenFor($user, 'second');

    $this->withToken($second)->postJson('/api/logout')->assertNoContent();
    $this->app['auth']->forgetGuards();
    $this->withToken($second)->getJson('/api/user')->assertUnauthorized();
    $this->app['auth']->forgetGuards();
    $this->withToken($first)->getJson('/api/user')->assertOk();
    $this->assertDatabaseCount('personal_access_tokens', 1);
});

it('requires a token to create a post', function () {
    $this->postJson('/api/posts', [
        'title' => 'Article sans jeton',
        'slug' => 'article-sans-jeton',
        'body' => 'Un contenu suffisamment long pour passer la validation.',
    ])->assertUnauthorized();
});

it('creates a post with a token', function () {
    $user = User::factory()->create();

    $this->withToken(apiTokenFor($user))
        ->postJson('/api/posts', [
            'title' => 'Article cree avec jeton',
            'slug' => 'article-cree-avec-jeton',
            'excerpt' => 'Cree par l API.',
            'body' => 'Un contenu suffisamment long pour passer la validation.',
            'is_published' => true,
        ])
        ->assertCreated()
        ->assertJsonPath('data.title', 'Article cree avec jeton')
        ->assertJsonPath('data.author', $user->name);

    $this->assertDatabaseHas('posts', ['slug' => 'article-cree-avec-jeton']);
});

it('rejects an invalid post body', function () {
    $user = User::factory()->create();

    $this->withToken(apiTokenFor($user))
        ->postJson('/api/posts', [
            'title' => 'Trop court',
            'slug' => 'trop-court',
            'body' => 'court',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('body');
});

it('forbids updating another user post', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $owner->id]);

    $this->withToken(apiTokenFor($other))
        ->putJson("/api/posts/{$post->id}", [
            'title' => 'Tentative de modification',
            'slug' => $post->slug,
            'body' => 'Un contenu suffisamment long pour passer la validation.',
        ])
        ->assertForbidden();
});
