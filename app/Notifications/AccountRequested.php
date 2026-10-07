<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRequested extends Notification
{
    public function __construct(public User $account) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('auth.request_admin_subject'))
            ->line(__('auth.request_admin_body', [
                'name' => $this->account->name,
                'email' => $this->account->email,
                'organization' => $this->account->organization,
                'role' => $this->account->role->label(),
            ]))
            ->action(__('auth.request_admin_action'), url('/admin/account-requests'));
    }
}
