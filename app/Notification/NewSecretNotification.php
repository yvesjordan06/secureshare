<?php

namespace App\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class NewSecretNotification extends Notification
{
    use Queueable, SerializesModels;

    public $secret;

    /**
     * Create a new message instance.
     */
    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A new secret has been shared with you')
            ->line('Click the button below to open it.')
            ->action('Open Now', route('secret.view', $this->receiver->id))
            ->line('SecureShare, Keep it private. Keep it safe.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
