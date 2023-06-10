<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatus;
use App\Models\BorrowedEquipment;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class BorrowedEquipmentController
 * @package App\Http\Controllers
 */
class BorrowedEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrowedEquipments = BorrowedEquipment::paginate();
        $allEquipment = Equipment::paginate();

        $borrowedEquipments->getCollection()->transform(function ($item) {
            return $this->formatBorrowedDates($item);
        });

        return view('borrowed-equipment.index', compact('borrowedEquipments', 'allEquipment'))
            ->with('i', (request()->input('page', 1) - 1) * $borrowedEquipments->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $borrowedEquipment = new BorrowedEquipment();
        $allEquipment = Equipment::where('status', 'Inzetbaar')
            ->pluck('title', 'id')
            ->toArray();
        return view('borrowed-equipment.create', compact('borrowedEquipment', 'allEquipment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(BorrowedEquipment::$rules);

        $borrowedEquipment = BorrowedEquipment::create($data);

        $this->updateEquipmentStatus($borrowedEquipment);

        return redirect()->route('borrowed-equipments.index')
            ->with('success', 'BorrowedEquipment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $borrowedEquipment = BorrowedEquipment::find($id);

        $borrowedEquipment = $this->formatBorrowedDates($borrowedEquipment);

        return view('borrowed-equipment.show', compact('borrowedEquipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $borrowedEquipment = BorrowedEquipment::find($id);

        $borrowedEquipment = $this->formatBorrowedDates($borrowedEquipment);

        return view('borrowed-equipment.edit', compact('borrowedEquipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  BorrowedEquipment $borrowedEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BorrowedEquipment $borrowedEquipment)
    {
        $data = $request->validate(BorrowedEquipment::$rules);

        $data = $this->formatBorrowedDates($data);

        $borrowedEquipment->update($data);

        return redirect()->route('borrowed-equipments.index')
            ->with('success', 'BorrowedEquipment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $borrowedEquipment = BorrowedEquipment::find($id);
        $borrowedEquipment->delete();

        return redirect()->route('borrowed-equipments.index')
            ->with('success', 'BorrowedEquipment deleted successfully');
    }

    /**
     * Show a list of borrowed equipment by category.
     *
     * @param string $category
     * @return \Illuminate\Http\Response
     */
    public function showList($category)
    {
        $query = $this->getByCategory($category);
        $borrowedEquipments = $query->paginate(10); // Hier is 10 het aantal items per pagina

        $category = EquipmentCategory::where('name', $category)->first();

        return view('borrowed-equipment.list', compact('borrowedEquipments', 'category'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Get a list of borrowed equipment by category in JSON format.
     *
     * @param string $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList($category)
    {
        $borrowedEquipmentsQuery = $this->getByCategory($category);
        $borrowedEquipments = $borrowedEquipmentsQuery->get();

        $borrowedEquipmentsWithEquipment = [];

        foreach ($borrowedEquipments as $borrowedEquipment) {
            $equipment = Equipment::find($borrowedEquipment->equipment_id);
            $borrowedEquipment->equipment_title = $equipment->title;
            $borrowedEquipmentsWithEquipment[] = $borrowedEquipment;
        }

        return response()->json($borrowedEquipmentsWithEquipment);
    }

    /**
     * Get borrowed equipment by category.
     *
     * @param string $category
     * @return mixed
     */
    public function getByCategory($category)
    {
        $query = BorrowedEquipment::query()
            ->join('equipment', 'equipment.id', '=', 'borrowed_equipment.equipment_id')
            ->join('equipment_categories', 'equipment_categories.id', '=', 'equipment.category_id')
            ->where('equipment_categories.name', $category)
            ->orderBy('borrowed_equipment.created_at', 'desc');

        return $query;
    }



    /**
     * Format borrowed dates in the given item.
     *
     * @param mixed $item
     * @return mixed
     */
    private function formatBorrowedDates($item)
    {
        $item->borrowed_date_begin = Carbon::parse($item->borrowed_date_begin)->format('d-m-Y H:i');
        $item->borrowed_date_end = Carbon::parse($item->borrowed_date_end)->format('d-m-Y H:i');

        return $item;
    }

    /**
     * Update the status of the associated Equipment to "RESERVED".
     *
     * @param BorrowedEquipment $borrowedEquipment
     * @return void
     */
    private function updateEquipmentStatus(BorrowedEquipment $borrowedEquipment)
    {
        $equipment = $borrowedEquipment->equipment;

        if ($equipment) {
            $equipment->status = EquipmentStatus::RESERVED;
            $equipment->save();
        }
    }
}
