<?php

use App\Models\Admin\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page when accessing the posts index', function () {
    $response = $this->get(route('posts.index'));

    $response->assertRedirect('/login');
});

test('authenticated users can visit the posts index', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200);
});

test('the posts index renders the correct inertia view and has the expected props', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Post::factory()->count(3)->create(['author_id' => $user->id]);

    $response = $this->get(route('posts.index'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('admin/posts/Index')
        ->has('posts')
        ->has('posts.data', 3)
    );
});

test('the posts index is paginated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Post::factory()->count(15)->create(['author_id' => $user->id]);

    $response = $this->get(route('posts.index'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('admin/posts/Index')
        ->has('posts.data', 10)
        ->where('posts.total', 15)
    );
});
