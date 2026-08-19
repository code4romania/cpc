<?php

namespace App\Notifications;

use App\Models\User;
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
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        $locale = $notifiable->locale;

        return (new MailMessage)
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
    public function toArray(User $notifiable): array
    {
        return [];
    }
}
