<?php

namespace App\Http\Controllers;

use App\Models\AttendanceEmployee;
use App\Models\AttendanceWeeklySchedule;
use App\Repositories\Interfaces\AttendanceWeeklyScheduleRepositoryInterface;
use Illuminate\Http\Request;

class AttendanceWeeklyScheduleController extends Controller
{
    private $attendanceWeeklyScheduleRepository;

    public function __construct(AttendanceWeeklyScheduleRepositoryInterface $attendanceWeeklyScheduleRepository)
    {
        $this->attendanceWeeklyScheduleRepository = $attendanceWeeklyScheduleRepository;
    }

    public function index()
    {
        $schedules = $this->attendanceWeeklyScheduleRepository->getAll();
        return view('schedules.index', compact('schedules'));
    }

    public function show($id)
    {
        $schedule = $this->attendanceWeeklyScheduleRepository->getById($id);
        return view('schedules.show', compact('schedule'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'day_of_week' => 'required',
            'category_id' => 'required',
        ]);

        $this->attendanceWeeklyScheduleRepository->create($data);

        return redirect()->route('schedules.index')->with('success', 'Weekly schedule created successfully.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'day_of_week' => 'required',
            'category_id' => 'required',
        ]);

        $this->attendanceWeeklyScheduleRepository->update($id, $data);

        return redirect()->route('schedules.index')->with('success', 'Weekly schedule updated successfully.');
    }

    public function destroy($id)
    {
        $this->attendanceWeeklyScheduleRepository->delete($id);

        return redirect()->route('schedules.index')->with('success', 'Weekly schedule deleted successfully.');
    }

    public function updateCategory($dayOfWeek, $attendanceId, $categoryId)
    {
        // Valideer het dayOfWeek nummer
        if ($dayOfWeek < 1 || $dayOfWeek > 5) {
            return response()->json(['message' => 'Invalid day of week'], 400);
        }

        // Valideer of het weekend is (zaterdag of zondag)
        if (date('N') >= 6) {
            $dayOfWeek = 1; // Set dayOfWeek to 1 (maandag) als het weekend is
        }

        // Zoek de AttendanceEmployee op basis van de attendanceId
        $attendanceEmployee = AttendanceEmployee::find($attendanceId);

        if (!$attendanceEmployee) {
            return response()->json(['message' => 'Attendance Employee not found'], 404);
        }

        // Zoek de AttendanceWeeklySchedule regel voor de juiste medewerker en dag van de week
        $weeklySchedule = AttendanceWeeklySchedule::where('employee_id', $attendanceId)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$weeklySchedule) {
            return response()->json(['message' => 'Attendance Weekly Schedule not found'], 404);
        }

        // Werk de categorie-ID van de regel bij
        $weeklySchedule->category_id = $categoryId;
        $weeklySchedule->save();

        return response()->json(['message' => 'Attendance Category updated successfully']);
    }


    public function createWeeklySchedules($employeeId)
    {
        // Verwijder bestaande wekelijkse schema's voor de werknemer
        AttendanceWeeklySchedule::where('employee_id', $employeeId)->delete();

        // Loop door de dagen van de week (1-5)
        for ($dayOfWeek = 1; $dayOfWeek <= 5; $dayOfWeek++) {
            AttendanceWeeklySchedule::create([
                'employee_id' => $employeeId,
                'category_id' => 1, // Vaste waarde voor de categorie-ID
                'day_of_week' => $dayOfWeek,
            ]);
        }

        return response()->json([
            'message' => '5 wekelijkse schema\'s succesvol aangemaakt voor de werknemer met ID ' . $employeeId,
        ]);
    }

     public function updateAllCategories(Request $request)
     {
         $schedulesData = $request->input('schedules');

         foreach ($schedulesData as $scheduleId => $categoryId) {
             $schedule = AttendanceWeeklySchedule::find($scheduleId);

             if ($schedule) {
                 $schedule->category_id = $categoryId;
                 $schedule->save();
             }
         }

         return redirect()->back()->with('success', 'Schema succesvol bijgewerkt!');

    }
}
