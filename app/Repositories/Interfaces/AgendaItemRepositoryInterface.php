<?php

namespace App\Repositories\Interfaces;

interface AgendaItemRepositoryInterface
{
    public function getAllAgendaItems($status = null);

    public function getAgendaItemById($id);

    public function createAgendaItem(array $data);

    public function updateAgendaItem($id, array $data);

    public function deleteAgendaItem($id);

    public function getActiveAgendaItems();

    public function getAgendaItemsByStatus($status);

}
