<?php

namespace App\Notifications;

use App\Support\ChannelResolver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * Shared behaviour for every notification the platform sends.
 *
 * Subclasses describe the message; this class decides where it goes, by asking
 * ChannelResolver what the recipient has asked for. Queued, so nothing in a
 * request is ever blocked on sending mail.
 */
abstract class BaseNotification extends Notification implements ShouldQueue
{
    // SerializesModels stores model identifiers rather than whole records, so a
    // queued notification reads current data when it finally runs.
    use Queueable, SerializesModels;

    /**
     * Catalog key, which drives both delivery and the preferences screen.
     */
    abstract public function key(): string;

    abstract public function title(): string;

    abstract public function body(): string;

    /**
     * Where the notification takes you when clicked.
     */
    abstract public function url(): string;

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ChannelResolver::resolve(
            $this->key(),
            method_exists($notifiable, 'notificationPreferenceFor')
                ? $notifiable->notificationPreferenceFor($this->key())
                : null,
        );
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title())
            ->greeting('Hello '.($notifiable->name ?? 'there').',')
            ->line($this->body())
            ->action('Open in the platform', $this->url())
            ->line('You can change which notifications you receive in your settings.');
    }

    /**
     * Stored for the in-app notification centre.
     *
     * @return array<string,mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'key' => $this->key(),
            'title' => $this->title(),
            'body' => $this->body(),
            'url' => $this->url(),
        ];
    }
}
