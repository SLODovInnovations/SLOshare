<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewFollow extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * NewFollow Constructor.
     */
    public function __construct(public string $type, public User $follower)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => $this->follower->username.' Imate novega sledilca!',
            'body'  => $this->follower->username.' vas je začel spremljati, tako, da bo prejemal obvestila o vaših dejavnostih.',
            'url'   => '/users/'.$this->follower->username,
        ];
    }
}
