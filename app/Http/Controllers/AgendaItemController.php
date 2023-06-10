<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use App\Repositories\Interfaces\AgendaItemRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgendaItemController extends Controller
{
    private $agendaItemRepository;

    public function __construct(AgendaItemRepositoryInterface $agendaItemRepository)
    {
        $this->agendaItemRepository = $agendaItemRepository;
    }

    public function index(Request $request, $status = null)
    {
        $pageTitle = 'Agendapunten Overzicht';
        $activeMenuItem = 'agenda-items';
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''],
            ['url' => '/agenda-items', 'label' => 'Agendapunten Overzicht', 'classes' => 'active'],
        ];

        $agendaItems = $this->agendaItemRepository->getAllAgendaItems($status);

        $expiredItems = $agendaItems->filter(function ($agendaItem) {
            $agendaItem->time = Carbon::parse($agendaItem->time)->format('d-m-Y H:i:s');
            return $agendaItem->getStatus() === 'Verlopen';
        });

        $agendaItems = $agendaItems->reject(function ($agendaItem) {
            return $agendaItem->getStatus() === 'Verlopen';
        });

        return view('agenda-item.index', compact('agendaItems', 'expiredItems'))
            ->with('status', $status)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs)
            ->with('i', 0);



    }

    public function status(Request $request, $status = null)
    {
        $pageTitle = 'Agendapunten Overzicht';
        $activeMenuItem = 'agenda-items';
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''],
            ['url' => '/agenda-items', 'label' => 'Agendapunten Overzicht', 'classes' => 'active'],
        ];

        $agendaItems = $this->agendaItemRepository->getAllAgendaItems($status);

        return view('agenda-item.index', compact('agendaItems'))
            ->with('status', $status)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs)
            ->with('i', 0);



    }

    public function create()
    {
        $pageTitle = 'Nieuwe Agendapunt Toevoegen';
        $activeMenuItem = 'agenda-items';
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''],
            ['url' => '/agenda-items', 'label' => 'Agendapunten Overzicht', 'classes' => ''],
            ['url' => '/agenda-items/create', 'label' => 'Nieuwe Agendapunt Toevoegen', 'classes' => 'active'],
        ];

        $agendaItem = new AgendaItem();
        return view('agenda-item.create', compact('agendaItem'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }

    public function store(Request $request)
    {
        $data = $request->validate(AgendaItem::$rules);
        $agendaItem = $this->agendaItemRepository->createAgendaItem($data);

        return redirect()->route('agenda-items.index')
            ->with('success', 'Agendapunt is toegevoegd.');
    }

    public function show($id)
    {
        $agendaItem = $this->agendaItemRepository->getAgendaItemById($id);

        return view('agenda-item.show', compact('agendaItem'));
    }

    public function edit($id)
    {
        $pageTitle = 'Wijzig Agendapunt';
        $activeMenuItem = 'agenda-items';
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''],
            ['url' => '/agenda-items', 'label' => 'Agendapunten Overzicht', 'classes' => ''],
            ['url' => '/agenda-items/'.$id.'/edit', 'label' => 'Wijzig Agendapunt', 'classes' => 'active'],
        ];
        $agendaItem = $this->agendaItemRepository->getAgendaItemById($id);

        return view('agenda-item.edit', compact('agendaItem'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(AgendaItem::$rules);
        $this->agendaItemRepository->updateAgendaItem($id, $data);

        return redirect()->route('agenda-items.index')
            ->with('success', 'Agendapunt met id #'.$id.' succesvol gewijzigd');
    }

    public function destroy($id)
    {
        $this->agendaItemRepository->deleteAgendaItem($id);

        return redirect()->route('agenda-items.index')
            ->with('success', 'Agendapunt met id #'.$id.' succesvol verwijderd');
    }

    public function getAgendaItems(Request $request)
    {
        $agendaItems = $this->agendaItemRepository->getActiveAgendaItems();

        $agendaItemsWithStatus = $agendaItems->map(function ($agendaItem) {
            return [
                'time' => $agendaItem->time,
                'location' => $agendaItem->location,
                'description' => $agendaItem->description,
                'status' => $agendaItem->getStatus(),
                'remainingTime' => $agendaItem->getRemainingTime(),
            ];
        });

        return response()->json($agendaItemsWithStatus);
    }

    public function statusFilter($status)
    {
        $agendaItems = $this->agendaItemRepository->getAgendaItemsByStatus($status);

        return view('agenda-items.index', compact('agendaItems'));
    }

    function sortByClosestToNow($a, $b) {
        $now = Carbon::now();
        $aTime = Carbon::parse($a->time);
        $bTime = Carbon::parse($b->time);

        return abs($aTime->diffInSeconds($now)) - abs($bTime->diffInSeconds($now));
    }

}
