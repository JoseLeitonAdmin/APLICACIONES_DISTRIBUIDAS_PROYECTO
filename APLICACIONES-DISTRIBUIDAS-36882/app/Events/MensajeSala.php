<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class MensajeSala implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public string $texto) {}

    public function broadcastOn(): Channel
    {
        return new Channel('sala');
    }
}
