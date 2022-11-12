<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewComment extends Notification
{
    use Queueable;

    /**
     * NewComment Constructor.
     */
    public function __construct(public string $type, public Comment $comment)
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
        if ($this->type == 'torrent') {
            if ($this->comment->anon == 0) {
                return [
                    'title' => 'Prejet nov komentar Torrenta',
                    'body'  => $this->comment->user->username.' vam je pustil komentar o Torrentu '.$this->comment->commentable->name,
                    'url'   => '/torrents/'.$this->comment->commentable->id,
                ];
            }

            return [
                'title' => 'Prejet nov komentar Torrenta',
                'body'  => 'Anonimnež vam je pustil komentar o Torrentu '.$this->comment->commentable->name,
                'url'   => '/torrents/'.$this->comment->torrent->id,
            ];
        }

        if ($this->comment->anon == 0) {
            return [
                'title' => 'Prejet je bil nov komentar o zahtevi',
                'body'  => $this->comment->user->username.' vam je pustil komentar zahtevo za Torrent '.$this->comment->commentable->name,
                'url'   => '/requests/'.$this->comment->commentable->id,
            ];
        }

        return [
            'title' => 'Prejet je bil nov komentar o zahtevi',
            'body'  => 'Anonimnež vam je pustil komentar zahtevo za Torrent '.$this->comment->commentable->name,
            'url'   => '/requests/'.$this->comment->commentable->id,
        ];
    }
}
