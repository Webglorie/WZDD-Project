<?php

namespace App\Observers;

use App\Models\AgendaItem;

class AgendaItemCreatorObserver
{
    /**
     * Handle the AgendaItem "created" event.
     */
    public function created(AgendaItem $agendaItem)
    {
        $agendaItem->created_by = auth()->user()->id;
        $agendaItem->save();
    }

    /**
     * Handle the AgendaItem "updated" event.
     */
    public function updated(AgendaItem $agendaItem): void
    {
        //
    }

    /**
     * Handle the AgendaItem "deleted" event.
     */
    public function deleted(AgendaItem $agendaItem): void
    {
        //
    }

    /**
     * Handle the AgendaItem "restored" event.
     */
    public function restored(AgendaItem $agendaItem): void
    {
        //
    }

    /**
     * Handle the AgendaItem "force deleted" event.
     */
    public function forceDeleted(AgendaItem $agendaItem): void
    {
        //
    }
}
