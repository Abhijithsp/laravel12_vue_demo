<?php

use App\Models\Admin\Chat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('chat belongs to a user', function () {
    $user = User::factory()->create();
    $chat = Chat::factory()->create(['author_id' => $user->id]);

    expect($chat->user)->toBeInstanceOf(User::class);
    expect($chat->user->id)->toBe($user->id);
});
