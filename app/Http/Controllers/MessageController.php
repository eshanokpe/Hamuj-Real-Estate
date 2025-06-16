<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\GuestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('throttle:10,1'); // 10 requests per minute
    }

    public function store(Request $request)
    {

        $request->validate([
            'content' => 'required|string|max:1000',
            'session_id' => 'nullable|string' // Only required for guests
        ]);

        
        // Determine user type and ID
        if (Auth::check()) {
            $userId = Auth::id();
            $userType = 'registered';
        } else {
            $request->validate(['session_id' => 'required|string']);
            
            $guest = GuestUser::firstOrCreate(
                ['session_id' => $request->session_id],
                [
                    'name' => 'Guest ' . Str::random(4),
                    'email' => null
                ]
            );
            $userId = $guest->session_id;
            $userType = 'guest';
        }
            
        // Find or create conversation
        $conversation = Conversation::firstOrCreate(
            [
                'user_id' => $userId,
                'user_type' => $userType,
                'is_open' => true
            ],
            [
                'subject' => $userType === 'guest' ? 'Guest Support Request' : 'User Support Request',
                'admin_id' => null
            ]
        );
       

        // Create the message
        $message = $conversation->messages()->create([
            'user_id' => $userId,
            'user_type' => $userType,
            'content' => $request->content
        ]);

        // Broadcast the message event
        broadcast(new \App\Events\NewMessage($message))->toOthers();

        // Notify admins (you'll need to implement this)
        $this->notifyAdmins($conversation, $message);

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'conversation_id' => $conversation->id
        ], 201);
    }

    protected function notifyAdmins($conversation, $message)
    {
        // Get all admin users
        $admins = User::where('is_admin', true)
                    ->where('is_active', true)
                    ->get();

        if ($admins->isEmpty()) {
            \Log::warning('No active admin users found to notify');
            return;
        }

        // 1. Database Notifications
        try {
            \Notification::send($admins, new \App\Notifications\NewSupportMessage($message));
        } catch (\Exception $e) {
            \Log::error('Failed to send database notification: ' . $e->getMessage());
        }

        // 2. Email Notifications (only if message is important or during business hours)
        if ($this->shouldSendEmailNotification()) {
            try {
                $admins->each(function ($admin) use ($message) {
                    \Mail::to($admin->email)->queue(
                        new \App\Mail\NewSupportMessageMail($message, $admin)
                    );
                });
            } catch (\Exception $e) {
                \Log::error('Failed to send email notification: ' . $e->getMessage());
            }
        }

        // 3. Real-time Pusher Notification
        try {
            $pusher = new \Pusher\Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                config('broadcasting.connections.pusher.options')
            );

            $pusher->trigger(
                'admin-channel',
                'new-message',
                [
                    'conversation_id' => $conversation->id,
                    'message_id' => $message->id,
                    'preview' => Str::limit($message->content, 50),
                    'user_type' => $message->user_type,
                    'created_at' => $message->created_at->toDateTimeString()
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send Pusher notification: ' . $e->getMessage());
        }
    }

    protected function shouldSendEmailNotification()
    {
        // Only send emails during business hours (9am-5pm)
        $now = now();
        $businessHoursStart = $now->copy()->setHour(9)->setMinute(0);
        $businessHoursEnd = $now->copy()->setHour(17)->setMinute(0);
        
        return $now->between($businessHoursStart, $businessHoursEnd);
    }
}