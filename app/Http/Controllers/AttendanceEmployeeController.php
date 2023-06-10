<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCategory;
use App\Models\AttendanceEmployee;
use App\Models\AttendanceWeeklySchedule;
use App\Repositories\AttendanceEmployeeRepository;
use Illuminate\Http\Request;

/**
 * Class AttendanceEmployeeController
 * @package App\Http\Controllers
 */
class AttendanceEmployeeController extends Controller
{
    /**
     * @var AttendanceEmployeeRepository
     */
    private $attendanceEmployeeRepository;

    /**
     * AttendanceEmployeeController constructor.
     * @param AttendanceEmployeeRepository $attendanceEmployeeRepository
     */
    public function __construct(AttendanceEmployeeRepository $attendanceEmployeeRepository)
    {
        $this->attendanceEmployeeRepository = $attendanceEmployeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendanceEmployees = $this->attendanceEmployeeRepository->getAll();

        return view('attendance-employees.index', compact('attendanceEmployees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attendanceEmployee = $this->attendanceEmployeeRepository->newInstance();
        return view('attendance-employees.create', compact('attendanceEmployee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(AttendanceEmployee::$rules);

        $attendanceEmployee = $this->attendanceEmployeeRepository->create($request->all());

        return redirect()->route('attendance-employees.index')
            ->with('success', 'AttendanceEmployee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendanceEmployee = $this->attendanceEmployeeRepository->find($id);

        return view('attendance-employees.show', compact('attendanceEmployee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendanceEmployee = $this->attendanceEmployeeRepository->find($id);

        return view('attendance-employees.edit', compact('attendanceEmployee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate(AttendanceEmployee::$rules);

        $attendanceEmployee = $this->attendanceEmployeeRepository->find($id);
        $attendanceEmployee->update($request->all());

        return redirect()->route('attendance-employees.index')
            ->with('success', 'AttendanceEmployee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AttendanceEmployee $employee)
    {
        try {
            // Verwijder eerst de bijbehorende weeklySchedules
            $employee->weeklySchedules()->delete();

            // Verwijder daarna de AttendanceEmployee zelf
            $employee->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = AttendanceWeeklySchedule::findOrFail($id);
        $categoryId = $request->input('category_id');
        $category = AttendanceCategory::findOrFail($categoryId);

        // Werk de categorie van de planning bij met de nieuwe waarde
        $schedule->category()->associate($category);
        $schedule->save();

        return response()->json(['success' => true]);
    }



    public function newEmployeeApi(Request $request)
    {
        // Valideer de ingevoerde gegevens
        $validatedData = $request->validate([
            'name' => 'required',
            'department_id' => 'required|exists:employee_departments,id',
        ]);

        // Maak een nieuwe AttendanceEmployee
        $employee = AttendanceEmployee::create([
            'name' => $validatedData['name'],
            'department_id' => $validatedData['department_id'],
        ]);

        return response()->json([
            'message' => 'AttendanceEmployee succesvol aangemaakt.',
            'employeeId' => $employee->id,
        ]);
    }



}
