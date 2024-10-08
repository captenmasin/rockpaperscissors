<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends \Illuminate\Broadcasting\BroadcastServiceProvider
{
    public function boot()
    {
        Broadcast::routes(['middleware' => ['web', 'authenticate-guest']]);
    }
}
