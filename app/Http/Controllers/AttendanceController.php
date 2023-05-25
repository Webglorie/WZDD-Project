<?php

namespace App\Http\Controllers;


use App\Models\AttendanceCategory;
use App\Models\AttendanceEmployee;
use App\Models\EmployeeDepartment;
use App\Models\WeekSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    public function index()
    {
        $pageTitle = 'ZIT Aanwezigheid Overzicht'; // H1-titel en meta-titel
        $activeMenuItem = 'attendance'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/attendance', 'label' => 'ZIT Aanwezigheid Overzicht', 'classes' => 'active'],
        ];


        // Haal de dag van vandaag op
        $currentDay = Carbon::now()->format('l');

        // Haal alle AttendanceCategories op
        $departments = EmployeeDepartment::all();

        $categories = AttendanceCategory::all();

        // Haal alle AttendanceEmployees op met hun WeekSchedule
        $employees = AttendanceEmployee::with('weekSchedule')->get();

        // Array om gegevens per werknemer op te slaan
        $employeeSchedules = [];

        // Loop door elke werknemer
        foreach ($employees as $employee) {
            // Decodeer de JSON van de WeekSchedule
            if ($employee->weekSchedule != null) {
                $schedule = json_decode($employee->weekSchedule->schedule, true);

                // Omdat zaterdag en zondag geen werkdagen zijn worden deze overgeslagen
                if($currentDay == 'Saturday' || $currentDay == 'Sunday'){
                    $currentDay = 'Monday';
                }
                // Haal de categorie voor de huidige dag op
                $category = $schedule[strtolower($currentDay)];

                // Sla de werknemer en bijbehorende categorie op
                $employeeSchedules[] = [
                    'employee' => $employee,
                    'category' => AttendanceCategory::find($category)
                ];
            } else {
                // Als er geen WeekSchedule is, voeg lege categorie toe
                $employeeSchedules[] = [
                    'employee' => $employee,
                    'category' => null
                ];
            }
        }

        return view('attendance.index', compact('categories', 'employeeSchedules', 'departments'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }


    public function updateSchedule(Request $request, $id)
    {
        $employee = AttendanceEmployee::findOrFail($id);
        $weekSchedule = $employee->weekSchedule;

        // Retrieve the schedule JSON from the request and decode it
        $scheduleData = json_decode($request->input('schedule'), true);

        // Update the schedule with the selected categories
        $weekSchedule->schedule = json_encode($scheduleData);
        $weekSchedule->save();

        // Redirect back to the index page or wherever you want
        return response()->json(['message' => 'Schedule updated successfully']);
    }




    public function store(Request $request)
    {
        // Valideer de ingediende gegevens
        $request->validate([
            'employee_name' => 'required',
            'department_id' => 'required',
        ]);

        // Maak een nieuwe AttendanceEmployee
        $attendanceEmployee = new AttendanceEmployee();
        $attendanceEmployee->name = $request->input('employee_name');
        $attendanceEmployee->department_id = $request->input('department_id');
        $attendanceEmployee->save();

        $createSchedule = new WeekSchedule();
        $createSchedule->employee_id = $attendanceEmployee->id;
        $createSchedule->save();

        // Return een JSON-respons met de toegevoegde AttendanceEmployee
        return response()->json($attendanceEmployee);
    }


    public function destroy($id)
    {
        $attendanceEmployee = AttendanceEmployee::findOrFail($id);
        $data = $attendanceEmployee;
        $attendanceEmployee->delete();



        return response()->json(['message' => $data]);
    }

    public function getCategories()
    {
        $categories = AttendanceCategory::all();

        return response()->json([
            'data' => $categories,
        ]);
    }


    public function getAttendanceToday()
    {
        $today = strtolower(date('l')); // Dagnaam van vandaag in kleine letters (bv. monday)
        $attendanceEmployees = AttendanceEmployee::with(['department', 'weekschedule'])
            ->get()
            ->map(function ($employee) use ($today) {
                $schedule = json_decode($employee->weekschedule->schedule, true);
                $categoryId = $schedule[$today] ?? null;
                $category = AttendanceCategory::findOrFail($categoryId);

                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'department_id' => $employee->department_id,
                    'department_name' => $employee->department->name,
                    'category_id' => $categoryId,
                    'category_name' => $category->name,
                ];
            });

        return response()->json($attendanceEmployees);
    }

}
