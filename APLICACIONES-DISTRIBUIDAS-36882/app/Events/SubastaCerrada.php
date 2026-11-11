<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class SubastaCerrada implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(
        public int $subastaId,
        public ?string $ganador,
        public int $precioFinal,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('subastas');
    }
}
