<?php

namespace App\Listeners;

use App\Events\GenerateTpl;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateTplListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GenerateTpl  $event
     * @return void
     */
    public function handle(GenerateTpl $event)
    {
        $event->getAllCategory();
        $event->getAllContent();
    }
}
