<?php

use App\Actions\Game\DeleteOldGames;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DeleteOldGames::class)->daily();
