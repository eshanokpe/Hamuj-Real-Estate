<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property; 
use App\Models\CustomNotification; 

class NotificationController extends Controller
{
    
    public function index()
    { 
        $notifications = auth()->user()->notifications()->with('property')->paginate(10);

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
        // return redirect()->route('property.show', ['slug' => $propertySlug]);
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
