<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class RecipientSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $transferDetails;
    protected array $channels;

    public function __construct(array $transferDetails, array $channels = ['mail', 'database'])
    {
        $this->transferDetails = $transferDetails;
        $this->channels        = $channels;
    }

    public function via($notifiable): array
    {
        return $this->channels;
    }

    // ─────────────────────────────────────────────
    // DATABASE channel  (what gets stored as JSON)
    // ─────────────────────────────────────────────
    public function toDatabase($notifiable): array
    {
        $sender     = User::find($this->transferDetails['sender_id']);
        $senderName = $sender
            ? ($sender->first_name . ' ' . $sender->last_name)
            : 'A User';

        $formattedPrice = number_format(
            ($this->transferDetails['total_price'] ?? 0) / 100, 2
        );

        return [
            // ── Identity ──────────────────────────────────────────
            'notification_status' => 'recipientSubmittedNotification',

            // ── Transfer identifiers (needed by submitConfirmation) ─
            'transfer_id'    => $this->transferDetails['transfer_id']  ?? null,
            'buy_id'         => $this->transferDetails['buy_id']        ?? null,  // ✅ critical
            'reference'      => $this->transferDetails['reference']     ?? null,

            // ── Parties ───────────────────────────────────────────
            'sender_id'      => $this->transferDetails['sender_id']    ?? null,
            'recipient_id'   => $this->transferDetails['recipient_id'] ?? null,

            // ── Property ──────────────────────────────────────────
            'property_id'    => $this->transferDetails['property_id']   ?? null,
            'property_slug'  => $this->transferDetails['property_slug'] ?? null,
            'property_name'  => $this->transferDetails['property_name'] ?? null,
            'property_image' => $this->transferDetails['property_image'] ?? null,
            'property_mode'  => 'transfer',

            // ── Asset details ─────────────────────────────────────
            'land_size'      => $this->transferDetails['land_size']    ?? null,
            'total_price'    => $this->transferDetails['total_price']  ?? 0,  // stored in kobo
            'purchase_date'  => $this->transferDetails['purchase_date'] ?? null,
            'roi_percentage' => $this->transferDetails['roi_percentage'] ?? 0,
            'total_roi'      => $this->transferDetails['total_roi'] ?? 0,
            'monthly_roi'    => $this->transferDetails['monthly_roi'] ?? 0,
            'roi_due_date'   => $this->transferDetails['roi_due_date'] ?? null,
            'is_matured'     => $this->transferDetails['is_matured'] ?? false,
            'months_elapsed' => $this->transferDetails['months_elapsed'] ?? 0,
            'days_into_month' => $this->transferDetails['days_into_month'] ?? 0,

            // ── Status ────────────────────────────────────────────
            'status'         => 'pending',  // always pending when first created
            'created_date'   => now()->toDateTimeString(),

            // ── Human-readable message ────────────────────────────
            'message' => 'You have received a ₦' . $formattedPrice .
                         ' asset transfer from ' . $senderName .
                         '. Please accept the transfer.',
        ];
    }

    /**
     * toArray() is the fallback Laravel uses when toDatabase() is absent.
     * Keep it identical so both channels store the same payload.
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    // ─────────────────────────────────────────────
    // MAIL channel
    // ─────────────────────────────────────────────
    public function toMail($notifiable): MailMessage
    {
        $sender     = User::find($this->transferDetails['sender_id']);
        $senderName = $sender
            ? ($sender->first_name . ' ' . $sender->last_name)
            : 'A User';

        $formattedPrice = number_format(
            ($this->transferDetails['total_price'] ?? 0) / 100, 2
        );

        $recipientName = $notifiable->first_name ?? $notifiable->name ?? 'User';

        return (new MailMessage)
            ->subject('Action Required: Accept Your Asset Transfer')
            ->greeting('Dear ' . $recipientName . ',')
            ->line('You have received an asset transfer of **₦' . $formattedPrice . '** from **' . $senderName . '** via ' . config('app.name') . '.')
            ->line('**Property:** ' . ($this->transferDetails['property_name'] ?? 'N/A'))
            ->line('**Land Size:** ' . ($this->transferDetails['land_size'] ?? 'N/A') . ' SQM')
            ->line('**Reference:** ' . ($this->transferDetails['reference'] ?? 'N/A'))
            ->line('To complete the transaction, log in to your account and accept the transfer from your notifications.')
            ->line('If you do not accept within **48 hours**, the asset will be returned to the sender.')
            ->line('If you have any questions, contact our support team.')
            ->line('Thank you for using ' . config('app.name') . '!')
            ->salutation('Best regards, ' . config('app.name') . ' Support Team');
    }
}
