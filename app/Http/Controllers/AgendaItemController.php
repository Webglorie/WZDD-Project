<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class AgendaItemController
 * @package App\Http\Controllers
 */
class AgendaItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status = null)
    {
        // Haal alle AgendaItems op
        $allAgendaItems = AgendaItem::all();

        // Filter op basis van status indien opgegeven
        if ($status) {
            $agendaItems = $allAgendaItems->filter(function ($agendaItem) use ($status) {
                return strtolower($agendaItem->getStatus()) === strtolower($status);
            });
        } else {
            $agendaItems = $allAgendaItems;
        }

        // Paginering is niet van toepassing omdat we alle items of gefilterde items tonen

        return view('agenda-item.index', compact('agendaItems'))
            ->with('i', 0);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agendaItem = new AgendaItem();
        return view('agenda-item.create', compact('agendaItem'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate(AgendaItem::$rules);

//        // Convert the input datetime format to the database format
//        $data['time'] = Carbon::createFromFormat('d-m-Y H:i', $data['time'])->format('Y-m-d H:i:s');

        $agendaItem = AgendaItem::create($data);

        return redirect()->route('agenda-items.index')
            ->with('success', 'AgendaItem created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agendaItem = AgendaItem::find($id);

        return view('agenda-item.show', compact('agendaItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agendaItem = AgendaItem::find($id);

        return view('agenda-item.edit', compact('agendaItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  AgendaItem $agendaItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgendaItem $agendaItem)
    {
        request()->validate(AgendaItem::$rules);

        $agendaItem->update($request->all());

        return redirect()->route('agenda-items.index')
            ->with('success', 'AgendaItem updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $agendaItem = AgendaItem::find($id)->delete();

        return redirect()->route('agenda-items.index')
            ->with('success', 'AgendaItem deleted successfully');
    }

    public function getAgendaItems(Request $request)
    {
        $agendaItems = AgendaItem::all()->filter(function ($agendaItem) {
            return $agendaItem->getStatus() !== 'Verlopen';
        });

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
        // Haal alle AgendaItems op
        $agendaItems = AgendaItem::all();

        // Filter de AgendaItems op basis van de opgegeven status
        $filteredItems = $agendaItems->filter(function ($agendaItem) use ($status) {
            return $agendaItem->getStatus() === $status;
        });

        return view('agenda-items.index', compact('filteredItems'));
    }

}
