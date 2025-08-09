<?php
// app/Http/Controllers/SmsController.php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SmsController extends Controller
{
   

    public function createMessagingService()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        try {
            // $service = $twilio->messaging->v1->services->create(
            //     "Dohmayn Technologies Limited" // FriendlyName
            // );

            $message = $twilio->messages->create(
                '+2348139267960', // Replace with your recipient's number
                [
                    'body' => 'You have an appointment with Owl, Inc. on Friday, November 3 at 4:00 PM. Reply C to confirm.',
                    'messagingServiceSid' => 'MGbb3f569c99bf5d186dd17642c8c88c03'
                ]
            );

            // return response()->json([
            //     'status' => 'success',
            //     'service_sid' => $service->sid,
            // ]);
            return response()->json([
                'status' => 'success',
                'service_sid' => $service->sid,
                'message_sid' => $message->sid
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


}