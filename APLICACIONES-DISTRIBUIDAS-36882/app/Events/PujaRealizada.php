<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class PujaRealizada implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(
        public int $subastaId,
        public int $monto,
        public string $lider,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('subastas');
    }
}