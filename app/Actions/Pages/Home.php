<?php

namespace App\Actions\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Lorisleiva\Actions\Concerns\AsAction;

class Home
{
    use AsAction;

    public function handle(): Response
    {
        return Inertia::render('Home');
    }
}
