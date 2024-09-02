<?php

namespace App\Actions\Game;

use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Pirsch\Facades\Pirsch;

class JoinGame
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        if (!$request->user()) {
            return redirect()->route('home');
        }

        if ($game->finished()) {
            return redirect()->route('home');
        }

        if (empty($game->player_one)) {
            $game->update(['player_one' => $request->user()->id]);
        }

        if (empty($game->player_two) && $game->player_one !== $request->user()->id) {
            $game->update(['player_two' => $request->user()->id]);
        }

        Pirsch::track(
            name: 'Player 2 joined',
            meta: [
                'game_id' => $game->id,
            ]
        );

        return redirect()->back();
    }
}
