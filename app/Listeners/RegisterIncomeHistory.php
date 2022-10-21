<?php

namespace App\Listeners;

use App\Event\IncomeCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterIncome
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
     * @param  IncomeCreated  $event
     * @return void
     */
    public function handle(IncomeCreated $event)
    {
        foreach($event->income->articles as $article){
           
        }
        
    }
}
