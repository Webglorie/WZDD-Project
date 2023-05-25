<?php
namespace App\Http\Controllers;

use App\Models\BorrowedEquipment;
use App\Models\Equipment;
use App\Models\EquipmentNote;
use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::all();

        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        // Logica voor het weergeven van het formulier voor het maken van een nieuwe uitrusting

        return view('equipment.create');
    }

    public function store(Request $request)
    {
        // Valideer de gegevens uit het verzoek
        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'ultimo_id' => 'required',
            'status' => 'required',
            'condition' => 'required',
        ]);

        // Maak een nieuwe uitrusting aan
        $equipment = new Equipment($validatedData);

        // Andere logica voor het opslaan van de uitrusting

        return redirect()->route('equipment.index');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);

        // Andere logica voor het ophalen van gegevens indien nodig

        return view('equipment.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        // Valideer de gegevens uit het verzoek
        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'ultimo_id' => 'required',
            'status' => 'required',
            'condition' => 'required',
        ]);

        $equipment = Equipment::findOrFail($id);

        // Bijwerken van de uitrusting met de nieuwe gegevens
        $equipment->update($validatedData);

        // Andere logica voor het bijwerken van de uitrusting

        return redirect()->route('equipment.index');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        // Andere logica indien nodig

        return redirect()->route('equipment.index');
    }

    public function changeStatus(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        // Valideer de gegevens uit het verzoek
        $validatedData = $request->validate([
            'new_status' => 'required',
        ]);

        // Haal de geselecteerde nieuwe conditie op
        $newStatus = $validatedData['new_status'];

        // Wijs de nieuwe conditie toe aan de uitrusting
        $equipment->status = $newStatus;
        $equipment->save();

        // Andere logica indien nodig

        return redirect()->route('equipment.index');
    }

    public function changeCondition(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        // Valideer de gegevens uit het verzoek
        $validatedData = $request->validate([
            'new_condition' => 'required',
        ]);

        // Haal de geselecteerde nieuwe conditie op
        $newCondition = $validatedData['new_condition'];

        // Wijs de nieuwe conditie toe aan de uitrusting
        $equipment->condition = $newCondition;
        $equipment->save();

        // Andere logica indien nodig

        return redirect()->route('equipment.index');
    }


    public function addNote(Request $request, $id)
    {
        // Valideer de gegevens uit het verzoek
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        $equipment = Equipment::findOrFail($id);

        // Maak een nieuwe notitie aan
        $note = new EquipmentNote([
            'content' => $validatedData['content'],
        ]);

        // Koppel de notitie aan de uitrusting
        $equipment->notes()->save($note);

        // Andere logica indien nodig

        return redirect()->route('equipment.index');
    }

    public function borrowEquipmentForm($id)
    {
        $equipment = Equipment::findOrFail($id);

        return view('equipment.borrow', compact('equipment'));
    }

    public function borrowEquipment(Request $request, $id)
    {
        // Valideer de gegevens uit het verzoek
        $validatedData = $request->validate([
            'borrower' => 'required',
            'borrowed_date_begin' => 'required',
            'borrowed_date_end' => 'required',
            'ultimo_ticket_number' => 'required',
        ]);

        $equipment = Equipment::findOrFail($id);

        // Maak een nieuwe uitgeleende uitrusting aan
        $borrowedEquipment = new BorrowedEquipment($validatedData);

        // Koppel de uitgeleende uitrusting aan de uitrusting
        $equipment->borrowedEquipment()->save($borrowedEquipment);

        // Andere logica indien nodig

        return redirect()->route('equipment.index');
    }

    public function getAvailableEquipment($categoryId)
    {
        $equipments = Equipment::where('category_id', $categoryId)
            ->where('status', EquipmentStatus::AVAILABLE)
            ->where('condition', '!=', EquipmentCondition::DEFECT)
            ->where('status', '!=', EquipmentStatus::RESERVED)
            ->whereDoesntHave('borrowedEquipment', function ($query) {
                $today = Carbon::now()->toDateString();
                $query->where('borrowed_date_begin', '<=', $today)
                    ->where('borrowed_date_end', '>=', $today);
            })
            ->get();

        return response()->json($equipments);
    }

    public function setAvailable(Equipment $equipment)
    {
        // Verwijder de bijbehorende BorrowedEquipment-regel
        $equipment->borrowedEquipment()->delete();

        // Wijzig de status van de Equipment naar "Inzetbaar"
        $equipment->status = EquipmentStatus::AVAILABLE;
        $equipment->save();

        // Eventueel extra logica of meldingen toevoegen

        return redirect()->back()->with('success', 'De status van de Equipment is gewijzigd naar Inzetbaar en de bijbehorende BorrowedEquipment-regel is verwijderd.');
    }
}
