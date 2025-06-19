<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use App\Events\AdminMessageSent;
use App\Events\AdminReplied;
use App\Models\Message;
use Illuminate\Http\Request;
 
class AdminSupportController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['messages', 'user'])
            ->where('is_open', true)
            ->latest()
            ->paginate(10);
            
        return view('admin.home.conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    { 
        // Load conversation with messages and user data
        $conversation->load([
            'messages' => function($query) {
                $query->orderBy('created_at', 'asc'); // Show oldest first at top
            },
            'user',
            'admin'
        ]);

        // Mark unread messages as read
        $conversation->messages()
            ->where('user_type', '!=', 'admin')
            ->where('read', false)
            ->update(['read' => true]);

        // Get available admins for assignment
        $availableAdmins = User::where('is_admin', true)
            ->where('id', '!=', optional($conversation->admin)->id)
            ->get();

        return view('admin.home.conversations.show', compact('conversation', 'availableAdmins'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        // Determine user info based on conversation type
        if ($conversation->user_type === 'registered') {
            // For registered users
            $messageData = [
                'user_id' => auth()->id(),
                'user_type' => 'admin',
                'content' => $request->content
            ];
        } else {
            // For guest users
            $messageData = [
                'user_id' => $conversation->user_id, // Use guest's session_id
                'user_type' => 'admin',
                'content' => $request->content
            ];
        }

        // Mark previous messages as read
        $conversation->messages()
            ->where('user_type', '!=', 'admin')
            ->where('read', false)
            ->update(['read' => true]);

        // Create the message
        $message = $conversation->messages()->create($messageData);

        // Broadcast the message
        broadcast(new AdminMessageSent($message, $conversation))->toOthers();
 
        // Notify the user
        $this->notifyUser($conversation, $message);

        if ($request->wantsJson()) {
            // return response()->json($message);
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'conversation' => [
                    'id' => $conversation->id,
                    'status' => $conversation->is_open ? 'open' : 'closed'
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function assignAdmin(Request $request, Conversation $conversation)
    { 
        $request->validate([
            'admin_id' => 'nullable|exists:users,id'
        ]);

        $conversation->update([
            'admin_id' => $request->admin_id
        ]);

        return redirect()->back()->with('success', 'Admin assigned successfully!');
    }

    public function closeConversation(Conversation $conversation)
    {
        $conversation->update(['is_open' => false]);
        return redirect()->back()->with('success', 'Conversation closed successfully!');
    }

    public function reopenConversation(Conversation $conversation)
    {
        $conversation->update(['is_open' => true]);
        return redirect()->back()->with('success', 'Conversation reopened successfully!');
    }

    protected function notifyUser($conversation, $message)
    {
        if ($conversation->user_type === 'registered') {
            // For registered users
            $user = User::find($conversation->user_id);
            $user->notify(new \App\Notifications\NewAdminReply($message));
            
            // Broadcast to registered user
            broadcast(new AdminReplied($message, $conversation->user_id, false))->toOthers();
        } else {
            // For guest users
            event(new AdminReplied($message, $conversation->user_id));
        }
    }
}