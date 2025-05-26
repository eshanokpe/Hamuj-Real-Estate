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
        $notifications = $user->notifications()->with('property')->paginate(60);

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

    public function show($encryptedId)
    { 
        $id = decrypt($encryptedId);
        $notification = auth()->user()->notifications()->findOrFail($id);
        // Mark as read if unread
        if ($notification->unread()) {
            $notification->markAsRead();
            
            // Update the unread count in real-time
            $unreadCount = auth()->user()->unreadNotifications->count();
            
            return view('user.pages.notifications.show', [
                'notification' => $notification,
                'unreadCount' => $unreadCount // Pass updated count to view
            ]);
        }

        return view('user.pages.notifications.show', ['notification' => $notification]);
    }

  

}
