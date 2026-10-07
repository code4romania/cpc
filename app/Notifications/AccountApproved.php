<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class AccountApproved extends Notification
{
    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $url = URL::temporarySignedRoute(
            'account.password',
            now()->addDays(7),
            ['locale' => $notifiable->locale, 'user' => $notifiable],
        );

        return (new MailMessage)
            ->subject(__('auth.approved_subject', [], $notifiable->locale))
            ->line(__('auth.approved_body', [], $notifiable->locale))
            ->action(__('auth.approved_action', [], $notifiable->locale), $url);
    }
}
