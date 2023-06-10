<?php

namespace App\Repositories;

use App\Models\AgendaItem;
use App\Repositories\Interfaces\AgendaItemRepositoryInterface;

class AgendaItemRepository implements AgendaItemRepositoryInterface
{
    public function getAllAgendaItems($status = null)
    {
        $query = AgendaItem::query();

        if ($status) {
            $agendaItems = $query->get();

            $filteredItems = $agendaItems->filter(function ($item) use ($status) {
                return strtolower($item->getStatus()) === strtolower($status);
            });

            return $filteredItems;
        }

        return $query->get();
    }



    public function getAgendaItemById($id)
    {
        return AgendaItem::findOrFail($id);
    }

    public function createAgendaItem(array $data)
    {
        return AgendaItem::create($data);
    }

    public function updateAgendaItem($id, array $data)
    {
        $agendaItem = AgendaItem::findOrFail($id);
        $agendaItem->update($data);
    }

    public function deleteAgendaItem($id)
    {
        $agendaItem = AgendaItem::findOrFail($id);
        $agendaItem->delete();
    }

    public function getActiveAgendaItems()
    {
        $activeAgendaItems = AgendaItem::all()->filter(function ($item) {
            return $item->getStatus() !== 'Verlopen';
        });

        return $activeAgendaItems;
    }


    public function getAgendaItemsByStatus($status)
    {
        $agendaItems = AgendaItem::all();

        $filteredItems = $agendaItems->filter(function ($item) use ($status) {
            return strtolower($item->getStatus()) === strtolower($status);
        });

        return $filteredItems;
    }


}
