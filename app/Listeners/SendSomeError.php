<?php

namespace App\Listeners;

use App\Events\HandleError;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class SendSomeError
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(HandleError $event): void
    {
        //
        Session::flash('error', $event->message);
    }
}
