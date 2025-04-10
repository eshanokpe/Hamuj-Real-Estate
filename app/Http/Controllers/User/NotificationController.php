<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property; 
use App\Models\CustomNotification; 

class NotificationController extends Controller
{
    
    public function index(Request $request)
    { 
        $user = auth()->user();
        $notifications = $user->notifications()->with('property')->paginate(30);

        $unreadCount = $user->unreadNotifications()->count();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $unreadCount,
            ]);
        }


        return view('user.pages.notifications.index', compact('notifications'));
    }

    public function markAsRead($notificationId, Request $request){
        $notification = auth()->user()->notifications()->findOrFail($notificationId);

        $notification->markAsRead();
        $notificationData = $notification->data;
        $propertySlug = $notificationData['property_slug'];
        $propertyMode = $request->input('property_mode'); 

        // return redirect()->route('property.show', ['slug' => $propertySlug]);
        return response()->json(
            [
                'success' => true,
                'slug' => $propertySlug,
                'property_mode' => $propertyMode,
            ]
        );
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        // Mark the notification as read
        if ($notification->unread()) {
            $notification->markAsRead();
        }
        $notification = auth()->user()->notifications()->paginate(10);

        return view('user.pages.notifications.index', ['notifications' => $notification]);
    }

}
