<?php

namespace App\Events;
namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameResult implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Game $game, public string $winner)
    {

    }

    public function broadcastOn()
    {
        return new PresenceChannel('game.' . $this->game->id);
    }

    public function broadcastAs(): string
    {
        return 'GameResult';
    }
}
