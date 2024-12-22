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

}
