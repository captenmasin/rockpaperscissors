<?php

namespace App\Actions\Pages;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowGame
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        if (empty($game->player_one)){
            $game->update(['player_one' => $request->user()->id]);
        }

        if (empty($game->player_two) && $game->player_one !== $request->user()->id){
            $game->update(['player_two' => $request->user()->id]);
        }

        return Inertia::render('Game', [
            'game' => $game->only('id', 'uuid', 'player_one', 'player_two'),
            'currentPlayer' => $this->getCurrentPlayer($request->user(), $game),
            'opponentPlayer' => $this->getOpponentPlayer($request->user(), $game),
            'gameFinished' => $game->finished(),
            'currentPlayerMove' => $this->getCurrentPlayerMove($request->user(), $game),
            'opponentPlayerMove' => $game->finished() ? $this->getOpponentPlayerMove($request->user(), $game) : null,
            'winner' => $game->finished() ? $game->winner : null,
        ]);
    }

    public function getCurrentPlayer(User $user, Game $game)
    {
        if ($game->player_one === $user->id) {
            return 'player_one';
        }

        if ($game->player_two === $user->id) {
            return 'player_two';
        }

        return 'spectator';
    }

    public function getOpponentPlayer(User $user, Game $game)
    {
        if ($this->getCurrentPlayer($user, $game) === 'player_one') {
            return 'player_two';
        }

        if ($this->getCurrentPlayer($user, $game) === 'player_two') {
            return 'player_one';
        }

        return null;
    }

    public function getCurrentPlayerMove(User $user, Game $game)
    {
        if ($this->getCurrentPlayer($user, $game) === 'player_one') {
            return $game->player_one_move;
        }

        if ($this->getCurrentPlayer($user, $game) === 'player_two') {
            return $game->player_two_move;
        }

        return null;
    }

    public function getOpponentPlayerMove(User $user, Game $game)
    {
        if ($this->getOpponentPlayer($user, $game) === 'player_one') {
            return $game->player_one_move;
        }

        if ($this->getOpponentPlayer($user, $game) === 'player_two') {
            return $game->player_two_move;
        }

        return null;
    }
}
