<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Log;
use \Twilio\Rest\Client;


class SmsChannel
{
    /**
     * Send the SMS notification
     */
    public function send($notifiable, Notification $notification)
    {
        try{  
                $message = $notification->toSms($notifiable);
                
                // Get user's phone number (defined in User model)
                $phoneNumber = $notifiable->routeNotificationForSms();
                \Log::debug('SMS Channel Attempt', [
                    'phone' => $phoneNumber,
                    'message' => $message
                ]);
                if (empty($phoneNumber)) {
                    throw new \Exception('No phone number provided');
                }
                // Send SMS (example using Twilio)
                $this->sendViaTwilio($phoneNumber, $message);
            } catch (\Exception $e) {
            \Log::error('SMS Notification Failed: ' . $e->getMessage());
            throw $e; // Re-throw to see in logs/API responses
        }
    }

    /**
     * Twilio SMS Implementation
     */ 
    protected function sendViaTwilio($to, $message)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        $messagingServiceSid = config('services.twilio.messagingServiceSid');

        $twilio = new Client($sid, $token);
        
       
        $twilio->messages->create(
            $to, 
            [
                'body' => $message,
                'messagingServiceSid' => $messagingServiceSid
            ]
        );
    }
}