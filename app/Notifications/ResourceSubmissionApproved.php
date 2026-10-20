<?php

namespace App\Notifications;

use App\Models\ResourceSubmission;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResourceSubmissionApproved extends Notification
{
    public function __construct(public ResourceSubmission $submission) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $locale = $this->submission->locale;

        return (new MailMessage)
            ->subject(__('auth.submission_approved_subject', [], $locale))
            ->line(__('auth.submission_approved_body', [
                'title' => $this->submission->title,
            ], $locale));
    }
}
