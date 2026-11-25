<?php

use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('promotes an author to administrator from the back office', function () {
    $author = User::factory()->create();
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $author), ['role' => 'admin'])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'Rôle de '.$author->name.' mis à jour : admin.');

    expect($author->fresh()->role)->toBe('admin');
});

it('refuses to change the role of an administrator', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $admin), ['role' => 'author'])
        ->assertForbidden();

    expect($admin->fresh()->role)->toBe('admin');
});
