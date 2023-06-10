<?php

namespace App\Http\Controllers;


use App\Models\AttendanceCategory;
use App\Models\AttendanceEmployee;
use App\Models\AttendanceWeeklySchedule;
use App\Repositories\Interfaces\AttendanceCategoryRepositoryInterface;
use Illuminate\Http\Request;

class AttendanceCategoryController extends Controller
{
    private $attendanceCategoryRepository;

    public function __construct(AttendanceCategoryRepositoryInterface $attendanceCategoryRepository)
    {
        $this->attendanceCategoryRepository = $attendanceCategoryRepository;
    }

    public function index()
    {
        $pageTitle = 'ZIT Aanwezigheid Overzicht';
        $activeMenuItem = 'attendance';
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''],
            ['url' => '/attendance', 'label' => 'ZIT Aanwezigheid Overzicht', 'classes' => 'active'],
        ];

        $categories = $this->attendanceCategoryRepository->getAllWithSchedulesAndEmployees();

        // Loop door de categorieën
        foreach ($categories as $category) {
            $employeesCountByDay = [];

            // Loop door de werkschema's van de categorie
            foreach ($category->weeklySchedules as $schedule) {
                $dayOfWeek = $schedule->day_of_week;

                // Als het day_of_week-cijfer nog niet bestaat in de array, maak dan een nieuwe entry aan met de waarde 1
                if (!isset($employeesCountByDay[$dayOfWeek])) {
                    $employeesCountByDay[$dayOfWeek] = 1;
                } else {
                    // Anders, verhoog het aantal werknemers voor de specifieke day_of_week met 1
                    $employeesCountByDay[$dayOfWeek]++;
                }
            }

            // Voeg de array met werknemersaantallen per day_of_week toe aan de categorie
            $category->employeesCountByDay = $employeesCountByDay;
        }

        $attendanceCategory = $this->attendanceCategoryRepository->createNew();
        $employees = $this->attendanceCategoryRepository->getAllEmployees();

        return view('attendance-categories.index', compact('categories', 'attendanceCategory', 'pageTitle', 'employees', 'activeMenuItem', 'breadcrumbs'));
    }

    public function create()
    {
        $attendanceCategory = $this->attendanceCategoryRepository->makeModel();

        return view('attendance-categories.create', compact('attendanceCategory'));
    }

    public function store(Request $request)
    {


        $attendanceCategory = $this->attendanceCategoryRepository->create($request->all());

        return redirect()->route('attendance-categories.index')
            ->with('success', 'AttendanceCategory created successfully.');
    }

    public function show($id)
    {
        $attendanceCategory = $this->attendanceCategoryRepository->find($id);
        $weeklySchedulesCount = AttendanceWeeklySchedule::where('attendance_category_id', $id)->count();

        return view('attendance-categories.show', compact('attendanceCategory', 'weeklySchedulesCount'));
    }

    public function edit($id)
    {
        $attendanceCategory = $this->attendanceCategoryRepository->find($id);

        return view('attendance-categories.edit', compact('attendanceCategory'));
    }

    public function update(Request $request, $id)
    {

        $attendanceCategory = $this->attendanceCategoryRepository->update($id, $request->all());

        return redirect()->route('attendance-categories.index')
            ->with('success', 'AttendanceCategory updated successfully');
    }

    public function destroy($id)
    {
        $this->attendanceCategoryRepository->delete($id);

        return redirect()->route('attendance-categories.index')
            ->with('success', 'AttendanceCategory deleted successfully');
    }

    public function updateCategory($attendanceId, $categoryId)
    {
        // Zoek de AttendanceEmployee op basis van de attendanceId
        $attendanceEmployee = AttendanceEmployee::find($attendanceId);

        if (!$attendanceEmployee) {
            return response()->json(['message' => 'Attendance Employee not found'], 404);
        }

        // Zoek de AttendanceCategory op basis van de categoryId
        $attendanceCategory = AttendanceCategory::find($categoryId);

        if (!$attendanceCategory) {
            return response()->json(['message' => 'Attendance Category not found'], 404);
        }

        // Werk de categorie-ID van de medewerker bij
        $attendanceEmployee->category_id = $attendanceCategory->id;
        $attendanceEmployee->save();

        return response()->json(['message' => 'Attendance Category updated successfully']);
    }
}
