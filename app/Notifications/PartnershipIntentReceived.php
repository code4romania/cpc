<?php

namespace App\Notifications;

use App\Models\PartnershipIntent;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnershipIntentReceived extends Notification
{
    public function __construct(public PartnershipIntent $intent) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('auth.partnership_received_subject', [], $notifiable->locale))
            ->line(__('auth.partnership_received_body', [
                'name' => $this->intent->contact_name,
                'email' => $this->intent->email,
                'organization' => $this->intent->entity_name,
            ], $notifiable->locale))
            ->action(__('auth.partnership_received_action', [], $notifiable->locale), url('/admin/partnership-intents'));
    }
}
