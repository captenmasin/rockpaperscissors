<?php

namespace App\Actions\Game;

use App\Events\GameResult;
use App\Events\PlayerMoved;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Pirsch\Facades\Pirsch;

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

        Pirsch::track(
            name: 'Move made',
            meta: [
                'game_id' => $game->id,
                'move' => $move,
            ]
        );

        $game->save();

        event(new PlayerMoved($game->id, $playerId));

        if ($game->player_one_move && $game->player_two_move) {
            $winner = $game->determineWinner();
            $game->winner = $winner;
            $game->save();

            Pirsch::track(
                name: 'Game finished',
                meta: [
                    'game_id' => $game->id,
                    'winner' => $winner,
                    'winning_move' => $winner === $game->player_one ? $game->player_one_move : $game->player_two_move,
                ]
            );

            event(new GameResult($game, $winner));
        }

        return redirect()->back();
    }
}
