<?php

namespace App\Actions\Game;

use App\Events\GameResult;
use App\Events\PlayerMoved;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class PlayerMove
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        $move = $request->input('move');
        $playerId = $request->user()->id;

        if ($game->player_one == $playerId) {
            $game->player_one_move = $move;
        } elseif ($game->player_two == $playerId) {
            $game->player_two_move = $move;
        }

        $game->save();

        event(new PlayerMoved($game->id, $playerId));

        if ($game->player_one_move && $game->player_two_move) {
            $winner = $game->determineWinner();
            $game->winner = $winner;
            $game->save();

            event(new GameResult($game, $winner));
        }

        return redirect()->back();
    }
}
