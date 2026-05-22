<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The OTP code for transaction verification
     *
     * @var string
     */
    protected string $otp;

    /**
     * The expiry time in minutes
     *
     * @var int
     */
    protected int $expiryMinutes;

    /**
     * Create a new notification instance.
     *
     * @param string $otp
     * @param int $expiryMinutes
     */
    public function __construct(string $otp, int $expiryMinutes = 15)
    {
        $this->otp = $otp;
        $this->expiryMinutes = $expiryMinutes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getEmailSubject())
            ->view('emails.transaction-otp', [
                'userName' => $notifiable->first_name ?? 'Valued Customer',
                'otp' => $this->otp,
                'expiryMinutes' => $this->expiryMinutes,
                'year' => now()->year,
                'companyName' => config('app.name', 'Dohmayn'),
                'companyEmail' => config('mail.from.address'),
                'companyPhone' => config('app.support_phone', '+234 806 199 9995'),
            ]);
    }

    /**
     * Get the email subject based on transaction type
     *
     * @return string
     */
    protected function getEmailSubject(): string
    {
        $appName = config('app.name', 'Dohmayn');
        return "[$appName] Transaction Verification Code - Action Required";
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'otp' => $this->otp,
            'expires_at' => now()->addMinutes($this->expiryMinutes)->toDateTimeString(),
            'type' => 'transaction_verification',
        ];
    }
}