<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\GuestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use App\Mail\NewSupportMessageMail;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:10,1');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
            'conversation_id' => 'nullable|exists:conversations,id'
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
            $userId = $guest->id;  // Use the database ID
            $userType = 'guest';
        }

        // Find or create conversation
        if ($request->conversation_id) {
            $conversation = Conversation::where('id', $request->conversation_id)
                ->where(function($query) use ($userId, $userType) {
                    $query->where('user_id', $userId)
                          ->where('user_type', $userType);
                })
                ->firstOrFail();
        } else {
            $conversation = Conversation::create([
                'user_id' => $userId,
                'user_type' => $userType,
                'is_open' => true,
                'subject' => $userType === 'guest' ? 'Guest Support Request' : 'User Support Request',
                'admin_id' => null
            ]);
        }

        // Create the message
        $message = $conversation->messages()->create([
            'user_id' => $userId,
            'user_type' => $userType,
            'content' => $request->content,
            'read' => false
        ]);

        // Broadcast the message event
        broadcast(new NewMessage($message, false))->toOthers();

        // Notify admins if this is a customer message
        if ($userType !== 'admin') {
            $this->notifyAdmins($conversation, $message);
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'conversation' => $conversation
        ], 201);
    }

    protected function notifyAdmins($conversation, $message)
    {
        $admins = User::where('is_admin', true)
                    ->where('is_active', true)
                    ->get();

        if ($admins->isEmpty()) return;

        try {
            // Database notification
            \Notification::send($admins, new \App\Notifications\NewSupportMessage($message));

            // Email notification
            if ($this->shouldSendEmailNotification()) {
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->queue(
                        new NewSupportMessageMail($message, $admin)
                    );
                }
            }
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }
    }

    protected function shouldSendEmailNotification()
    {
        $now = now();
        return $now->between(
            $now->copy()->setHour(9)->setMinute(0),
            $now->copy()->setHour(17)->setMinute(0)
        );
    }
}