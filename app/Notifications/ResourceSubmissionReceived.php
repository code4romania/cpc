<?php

namespace App\Notifications;

use App\Models\ResourceSubmission;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResourceSubmissionReceived extends Notification
{
    public function __construct(public ResourceSubmission $submission) {}

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
            ->subject(__('auth.submission_received_subject', [], $notifiable->locale))
            ->line(__('auth.submission_received_body', [
                'name' => $this->submission->submitter_name,
                'title' => $this->submission->title,
            ], $notifiable->locale))
            ->action(__('auth.submission_received_action', [], $notifiable->locale), url('/admin/resource-submissions'));
    }
}
