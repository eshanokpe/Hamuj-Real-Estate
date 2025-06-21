<?php

use Illuminate\Support\Facades\Route;
use Ilmedova\Chattle\app\Http\Controllers\Chat\AdminController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\CreateController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\GetMessagesController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\PostMessageController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\GetChatsController;

Route::prefix('chattle')->group(function () {
    Route::view('chat', 'chattle::chat'); 
    Route::post('/create-chat', [CreateController::class, 'createChat']);
    Route::post('/post-message', [PostMessageController::class, 'postMessage']);

    Route::get('/get-messages', [GetMessagesController::class, 'getMessages']);

    
    Route::get('/get-chats', [GetChatsController::class, 'getChats']);
}); 

