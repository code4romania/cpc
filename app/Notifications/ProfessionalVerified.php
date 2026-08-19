<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfessionalVerified extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $locale = $notifiable->locale ?? config('cpc.default_locale', 'ro');

        return (new MailMessage)
            ->locale($locale)
            ->subject(__('auth.verified_email_subject', [], $locale))
            ->greeting(__('auth.verified_email_greeting', ['name' => $notifiable->name], $locale))
            ->line(__('auth.verified_email_body', [], $locale))
            ->action(
                __('auth.verified_email_action', [], $locale),
                localized_route('portal.index', [], $locale),
            )
            ->line(__('auth.verified_email_thanks', [], $locale));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
