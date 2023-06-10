<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    private $equipmentRepository;

    public function __construct(EquipmentRepositoryInterface $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    public function index()
    {
        $equipment = $this->equipmentRepository->getAllEquipment();

        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        return view('equipment.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'ultimo_id' => 'required',
            'status' => 'required',
            'condition' => 'required',
        ]);

        $equipment = $this->equipmentRepository->createEquipment($validatedData);

        return redirect()->route('equipment.index');
    }

    public function edit($id)
    {
        $equipment = $this->equipmentRepository->getEquipmentById($id);

        return view('equipment.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'ultimo_id' => 'required',
            'status' => 'required',
            'condition' => 'required',
        ]);

        $equipment = $this->equipmentRepository->updateEquipment($id, $validatedData);

        return redirect()->route('equipment.index');
    }

    public function destroy($id)
    {
        $this->equipmentRepository->deleteEquipment($id);

        return redirect()->route('equipment.index');
    }

    public function changeStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'new_status' => 'required',
        ]);

        $equipment = $this->equipmentRepository->getEquipmentById($id);

        $newStatus = $validatedData['new_status'];

        $this->equipmentRepository->changeStatus($equipment, $newStatus);

        return redirect()->route('equipment.index');
    }

    public function changeCondition(Request $request, $id)
    {
        $validatedData = $request->validate([
            'new_condition' => 'required',
        ]);

        $equipment = $this->equipmentRepository->getEquipmentById($id);

        $newCondition = $validatedData['new_condition'];

        $this->equipmentRepository->changeCondition($equipment, $newCondition);

        return redirect()->route('equipment.index');
    }

    public function addNote(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        $equipment = $this->equipmentRepository->getEquipmentById($id);

        $note = $this->equipmentRepository->createEquipmentNote($equipment, $validatedData['content']);

        return redirect()->route('equipment.index');
    }

    public function borrowEquipmentForm($id)
    {
        $equipment = $this->equipmentRepository->getEquipmentById($id);

        return view('equipment.borrow', compact('equipment'));
    }

    public function borrowEquipment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'borrower' => 'required',
            'borrowed_date_begin' => 'required',
            'borrowed_date_end' => 'required',
            'ultimo_ticket_number' => 'required',
        ]);

        $equipment = $this->equipmentRepository->getEquipmentById($id);

        $borrowedEquipment = $this->equipmentRepository->borrowEquipment($equipment, $validatedData);

        return redirect()->route('equipment.index');
    }

    public function getAvailableEquipment($categoryId)
    {
        $equipments = $this->equipmentRepository->getAvailableEquipment($categoryId);

        return response()->json($equipments);
    }

    public function setAvailable($id)
    {
        $equipment = $this->equipmentRepository->getEquipmentById($id);

        $this->equipmentRepository->setEquipmentAvailable($equipment);

        return redirect()->back()->with('success', 'De status van de Equipment is gewijzigd naar Inzetbaar en de bijbehorende BorrowedEquipment-regel is verwijderd.');
    }
}
