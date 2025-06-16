<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// routes/channels.php
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
 
Broadcast::channel('guest.{sessionId}', function ($user, $sessionId) {
    return true; // Allow all guest connections
});

// Authenticated user channels
Broadcast::channel('private-user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Guest user channels
Broadcast::channel('private-guest.{sessionId}', function ($user, $sessionId) {
    return !$user && request()->session()->getId() === $sessionId;
});

// Application-specific channels
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return $user->conversations->contains($conversationId);
});

// For admin notifications
Broadcast::channel('private-admin.{adminId}', function ($user, $adminId) {
    return (int) $user->id === (int) $adminId && $user->is_admin;
});

// Conversation channel for all participants
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    return \App\Models\Conversation::where('id', $conversationId)
        ->where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('admin_id', $user->id);
        })->exists();
});
