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
            $item->borrowed_date_begin = Carbon::parse($item->borrowed_date_begin)->format('d-m-Y H:i');
            return $item;
        });

        $borrowedEquipments->getCollection()->transform(function ($item) {
            $item->borrowed_date_end = Carbon::parse($item->borrowed_date_end)->format('d-m-Y H:i');
            return $item;
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
        $data = request()->validate(BorrowedEquipment::$rules);

        $borrowedEquipment = BorrowedEquipment::create($data);

        // Update the status of the associated Equipment to "RESERVED"
        $equipment = $borrowedEquipment->equipment;
        if ($equipment) {
            $equipment->status = EquipmentStatus::RESERVED;
            $equipment->save();
        }

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

        $borrowedEquipment->borrowed_date_begin = Carbon::parse($borrowedEquipment->borrowed_date_begin)->format('d-m-Y H:i');
        $borrowedEquipment->borrowed_date_end = Carbon::parse($borrowedEquipment->borrowed_date_end)->format('d-m-Y H:i');

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

        $borrowedEquipment->borrowed_date_begin = Carbon::parse($borrowedEquipment->borrowed_date_begin)->format('d-m-Y H:i');
        $borrowedEquipment->borrowed_date_end = Carbon::parse($borrowedEquipment->borrowed_date_end)->format('d-m-Y H:i');


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
        $data = request()->validate(BorrowedEquipment::$rules);


        $data['borrowed_date_begin'] = Carbon::parse($request->input('borrowed_date_begin'))->format('Y-m-d H:i');
        $data['borrowed_date_end'] = Carbon::parse($request->input('borrowed_date_end'))->format('Y-m-d H:i');

//        // Convert the input datetime format to the database format
//        $data['borrowed_date_begin'] = Carbon::createFromFormat('d-m-Y H:i', $data['borrowed_date_begin'])->format('Y-m-d H:i:s');
//        $data['borrowed_date_end'] = Carbon::createFromFormat('d-m-Y H:i', $data['borrowed_date_end'])->format('Y-m-d H:i:s');

        $borrowedEquipment->update($data);

        return redirect()->route('borrowed-equipments.index')
            ->with('success', 'BorrowedEquipment updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $borrowedEquipment = BorrowedEquipment::find($id)->delete();

        return redirect()->route('borrowed-equipments.index')
            ->with('success', 'BorrowedEquipment deleted successfully');
    }

    public function showList($category)
    {
        $borrowedEquipments = $this->getByCategory($category);
        $category = EquipmentCategory::where('name', $category)->first();

        $borrowedEquipmentsList = BorrowedEquipment::paginate();

        return view('borrowed-equipment.list', compact('borrowedEquipments', 'category'))
            ->with('i', (request()->input('page', 1) - 1) * $borrowedEquipmentsList->perPage());
    }

    public function getList($category)
    {
        $borrowedEquipments = $this->getByCategory($category);

        // Extra logica om de Equipment-titel toe te voegen
        $borrowedEquipmentsWithEquipment = [];
        foreach ($borrowedEquipments as $borrowedEquipment) {
            $equipment = Equipment::find($borrowedEquipment->equipment_id);
            $borrowedEquipment->equipment_title = $equipment->title;
            $borrowedEquipmentsWithEquipment[] = $borrowedEquipment;
        }

        return response()->json($borrowedEquipmentsWithEquipment);
    }


    public function getByCategory($category)
    {
        $category = EquipmentCategory::where('name', $category)->first();

        if ($category) {
            $borrowedEquipment = BorrowedEquipment::whereHas('equipment.category', function ($query) use ($category) {
                $query->where('id', $category->id);
            })->get();

            return $borrowedEquipment;
        } else {
            return null;
        }
    }



}
