<?php

use App\Models\Conversation;
use App\Models\User;
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

Broadcast::routes(['middleware' => ['web']]);

// User private channel (for authenticated users)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// User notification channel
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Guest user channel (for unauthenticated users)
Broadcast::channel('guest.{sessionId}', function ($user, $sessionId) {
    return !$user && request()->hasHeader('X-Session-ID') && 
           request()->header('X-Session-ID') === $sessionId;
});

// Authenticated user private channel
Broadcast::channel('private-user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Guest user private channel
Broadcast::channel('private-guest.{sessionId}', function ($user, $sessionId) {
    return !$user && request()->hasHeader('X-Session-ID') && 
           request()->header('X-Session-ID') === $sessionId;
});

// Chat conversation channel
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::find($conversationId);
    
    if (!$conversation) return false;
    
    // Check if user is participant
    if ($conversation->user_type === 'registered' && $conversation->user_id === $user->id) {
        return true;
    }
    
    // Check if user is assigned admin
    if ($conversation->admin_id === $user->id) {
        return true;
    }
    
    return false;
});

// Admin notification channel
Broadcast::channel('private-admin.{adminId}', function ($user, $adminId) {
    return (int) $user->id === (int) $adminId && $user->is_admin;
});

// Main conversation channel (for both users and admins)
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::find($conversationId);
    
    if (!$conversation) return false;
    
    // For registered users
    if ($conversation->user_type === 'registered') {
        return $conversation->user_id === $user->id || 
               $conversation->admin_id === $user->id;
    }
    
    // For guest users
    if ($conversation->user_type === 'guest') {
        // Check if authenticated admin
        if ($conversation->admin_id === $user->id) {
            return true;
        }
        // Check if guest session matches
        return !$user && request()->hasHeader('X-Session-ID') && 
               $conversation->user_id === request()->header('X-Session-ID');
    }
    
    return false;
});

// Private conversation channel (recommended naming convention)
// routes/channels.php
Broadcast::channel('private-conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = App\Models\Conversation::find($conversationId);
    
    if (!$conversation) return false;
    
    // Admin can access any conversation
    if ($user && $user->is_admin) return true;
    
    // Registered user check
    if ($conversation->user_type === 'registered') {
        return $user && $conversation->user_id === $user->id;
    }
    
    // Guest user check
    if ($conversation->user_type === 'guest') {
        return !$user && request()->hasHeader('X-Session-ID') && 
               $conversation->user_id === request()->header('X-Session-ID');
    }
    
    return false;
});