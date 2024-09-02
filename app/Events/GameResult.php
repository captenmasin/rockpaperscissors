<?php

namespace App\Events;

namespace App\Events;

use App\Models\Game;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class GameResult implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Game $game, public string $winner) {}

    public function broadcastOn()
    {
        return new PresenceChannel('game.'.$this->game->id);
    }

    public function broadcastAs(): string
    {
        return 'GameResult';
    }
}
