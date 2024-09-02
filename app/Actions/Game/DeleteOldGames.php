<?php

namespace App\Actions\Game;

use App\Models\Game;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteOldGames
{
    use AsAction;

    public string $commandSignature = 'games:delete-old';

    public function handle(): void
    {
        $games = Game::where('created_at', '<', now()->subDays(7))
            ->whereNull('winner')
            ->delete();
    }

    public function asCommand(Command $command): void
    {
        $command->info('Deleting old games...');
        $this->handle();
    }
}
