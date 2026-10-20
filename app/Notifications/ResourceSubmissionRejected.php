<?php

namespace App\Notifications;

use App\Models\ResourceSubmission;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResourceSubmissionRejected extends Notification
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
            ->subject(__('auth.submission_rejected_subject', [], $locale))
            ->line(__('auth.submission_rejected_body', [
                'title' => $this->submission->title,
                'reason' => $this->submission->rejection_reason,
            ], $locale));
    }
}
