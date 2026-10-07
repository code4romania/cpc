<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class AccountRenewal extends Notification
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
            'account.renew',
            now()->addMonth(),
            ['locale' => $notifiable->locale, 'user' => $notifiable],
        );

        return (new MailMessage)
            ->subject(__('auth.renewal_subject', [], $notifiable->locale))
            ->line(__('auth.renewal_body', [], $notifiable->locale))
            ->action(__('auth.renewal_action', [], $notifiable->locale), $url);
    }
}
