<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth('admin')->user();
        $notifications = $admin->notifications()->latest()->paginate(30);
        $unreadCount = $admin->unreadNotifications()->count();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $unreadCount,
            ]);
        }

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($notificationId, Request $request)
    {
        $notification = DatabaseNotification::findOrFail($notificationId);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    public function show($id)
    {
        $notification = DatabaseNotification::findOrFail($id);

        //dd($notification);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }


        return view('admin.home.notification.show', compact('notification'));
    }
}
