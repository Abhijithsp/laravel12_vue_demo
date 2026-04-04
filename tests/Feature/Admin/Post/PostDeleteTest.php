<?php

use App\Models\Admin\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('author can delete their post and its image', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $user->id,
        'image' => 'images/sample.jpg'
    ]);

    Storage::disk('public')->put('images/sample.jpg', 'fake content');

    $this->actingAs($user)
        ->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post and image deleted successfully.');

    // Assert soft deleted
    $this->assertSoftDeleted($post);

    // Assert file deleted from the correct disk and path
    Storage::disk('public')->assertMissing('images/sample.jpg');
});

test('unauthorized users cannot delete others posts', function () {
    $author = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['author_id' => $author->id]);

    $this->actingAs($otherUser)
        ->delete(route('posts.destroy', $post))
        ->assertForbidden();

    $this->assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => null]);
});

test('guests are redirected to login when trying to delete a post', function () {
    $post = Post::factory()->create();

    $this->delete(route('posts.destroy', $post))
        ->assertRedirect('/login');

    $this->assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => null]);
});
