<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'player_one' => 'integer',
            'player_two' => 'integer',
        ];
    }

    protected $fillable = [
        'uuid',
        'player_one',
        'player_two',
        'player_one_move',
        'player_two_move',
        'winner'
    ];

    public function resetGame()
    {
        $this->update([
            'player_one_move' => null,
            'player_two_move' => null,
            'winner' => null,
        ]);
    }

    public function finished(): bool
    {
        return $this->player_one_move && $this->player_two_move;
    }

    public function started(): bool
    {
        return $this->player_one_move || $this->player_two_move;
    }

    public function getMovesAttribute(): array
    {
        return [
            'player_one' => $this->player_one_move,
            'player_two' => $this->player_two_move,
        ];
    }

    public function determineWinner()
    {
        $move1 = $this->player_one_move;
        $move2 = $this->player_two_move;

        if ($move1 === $move2) {
            return 'draw';
        }

        $winningMoves = [
            'rock' => 'scissors',
            'scissors' => 'paper',
            'paper' => 'rock',
        ];

        if ($winningMoves[$move1] === $move2) {
            return 'player_one';
        }

        return 'player_two';
    }
}
