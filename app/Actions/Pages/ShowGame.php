<?php

namespace App\Actions\Pages;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowGame
{
    use AsAction;

    public function handle(Request $request, Game $game): RedirectResponse|Response
    {
        if ($game->finished() && $request->user()->id !== $game->player_one && $request->user()->id !== $game->player_two) {
            return redirect()->route('home');
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

    public function updatePlayers(Request $request, Game $game)
    {
//        if (!$request->user()){
//            return;
//        }
//        if ($game->finished()){
//            return;
//        }
//
//        if (empty($game->player_one)){
//            $game->update(['player_one' => $request->user()->id]);
//        }
//
//        if (empty($game->player_two) && $game->player_one !== $request->user()->id){
//            $game->update(['player_two' => $request->user()->id]);
//        }
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
