<?php

namespace App\Listeners;

use App\Events\NewEvent;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class NewEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle(NewEvent $event)
    {
        Mail::to( ($event->data)['email'] )->send(new Email($event->data));
    }
}
