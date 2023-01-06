<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewCommentTag extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * NewCommentTag Constructor.
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
                    'title' => $this->comment->user->username.' vas je označil',
                    'body'  => $this->comment->user->username.' vas je označil v komentarju na Torrentu '.$this->comment->commentable->name,
                    'url'   => '/torrents/'.$this->comment->commentable->id,
                ];
            }

            return [
                'title' => 'Označeni ste bili',
                'body'  => 'Anonimni vas je označil v komentarju na Torrentu '.$this->comment->commentable->name,
                'url'   => '/torrents/'.$this->comment->commentable->id,
            ];
        }

        if ($this->type == 'torrentrequest') {
            if ($this->comment->anon == 0) {
                return [
                    'title' => $this->comment->user->username.' vas je označil',
                    'body' => $this->comment->user->username.' vas je označil v komentarju na Torrentu Prošnje '.$this->comment->commentable->name,
                    'url' => '/requests/'.$this->comment->commentable->id,
                ];
            }

            return [
                'title' => 'Označeni ste bili',
                'body' => 'Anonimni vas je označil v komentarju na Torrentu Prošnje '.$this->comment->commentable->name,
                'url' => '/requests/'.$this->comment->commentable->id,
            ];
        }

        if ($this->type == 'ticket') {
            if ($this->comment->anon == 0) {
                return [
                    'title' => $this->comment->user->username.' vas je označil',
                    'body' => $this->comment->user->username.' vas je označil v komentarju na Ticket '.$this->comment->commentable->subject,
                    'url' => '/tickets/'.$this->comment->commentable->id,
                ];
            }

            return [
                'title' => 'Označeni ste bili',
                'body' => 'Anonimni te je označil v komentarju na Ticket '.$this->comment->commentable->subject,
                'url' => '/tickets/'.$this->comment->commentable->id,
            ];
        }

        if ($this->type == 'playlist') {
            if ($this->comment->anon == 0) {
                return [
                    'title' => $this->comment->user->username.' vas je označil',
                    'body' => $this->comment->user->username.' vas je označil v komentarju na seznamu predvajanja '.$this->comment->commentable->name,
                    'url' => '/playlists/'.$this->comment->commentable->id,
                ];
            }

            return [
                'title' => 'Označeni ste bili',
                'body' => 'Anonimni vas je označil v komentarju na seznamu predvajanja '.$this->comment->commentable->name,
                'url' => '/playlists/'.$this->comment->commentable->id,
            ];
        }

        if ($this->type == 'collection') {
            if ($this->comment->anon == 0) {
                return [
                    'title' => $this->comment->user->username.' vas je označil',
                    'body' => $this->comment->user->username.' vas je označil v komentarju na zbirki '.$this->comment->commentable->name,
                    'url' => '/mediahub/collections/'.$this->comment->commentable->id,
                ];
            }

            return [
                'title' => 'Označeni ste bili',
                'body' => 'Anonimni vas je označil v komentarju o zbirki '.$this->comment->commentable->name,
                'url' => '/mediahub/collections/'.$this->comment->commentable->id,
            ];
        }

        if ($this->comment->anon == 0) {
            return [
                'title' => $this->comment->user->username.' vas je označil',
                'body' => $this->comment->user->username.' vas je označil v komentarju na članek '.$this->comment->commentable->title,
                'url' => '/articles/'.$this->comment->commentable->id,
            ];
        }

        return [
            'title' => 'Označeni ste bili',
            'body' => 'Anonimni vas je označil v komentarju na članek '.$this->comment->commentable->title,
            'url' => '/articles/'.$this->comment->commentable->id,
        ];
    }
}
