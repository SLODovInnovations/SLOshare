<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chatter implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $echoes;

    public $message;

    public $ping;

    public $audibles;

    /**
     * Chatter Constructor.
     */
    public function __construct(public string $type, public $target, $payload)
    {
        if ($type == 'echo') {
            $this->echoes = $payload;
        } elseif ($type == 'audible') {
            $this->audibles = $payload;
        } elseif ($type == 'new.message') {
            $this->message = $payload;
        } elseif ($type == 'new.bot') {
            $this->message = $payload;
        } elseif ($type == 'new.ping') {
            $this->ping = $payload;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chatter.'.$this->target);
    }
}
