<?php

namespace App\Http\Controllers;


use App\Models\AttendanceCategory;
use App\Models\AttendanceEmployee;
use App\Models\EmployeeDepartment;
use App\Models\AttendanceWeeklySchedule;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    private $attendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function index()
    {
        // Bepaal de huidige dag van de week
        $currentDayOfWeek = Carbon::now()->timezone(config('app.timezone'))->dayOfWeek;


        // Als het zaterdag of zondag is, stel dan de dag van de week in op 1 (maandag)
        if ($currentDayOfWeek == Carbon::SATURDAY || $currentDayOfWeek == Carbon::SUNDAY) {
            $currentDayOfWeek = Carbon::MONDAY;
        }

        // Gebruik de repository om de gewenste gegevens op te halen
        $weeklySchedules = $this->attendanceRepository->getByDayOfWeek($currentDayOfWeek);

        // Maak een lege array om de gegevens voor de JSON op te slaan
        $data = [];

        // Loop door alle WeeklySchedules en voeg de vereiste gegevens toe aan de array
        foreach ($weeklySchedules as $weeklySchedule) {
            $attendanceEmployee = $weeklySchedule->employee;
            $attendanceCategory = $weeklySchedule->category;

            // Voeg de gewenste gegevens toe aan de array
            $data[] = [
                'employee_name' => $attendanceEmployee->name,
                'department_id' => $attendanceEmployee->department_id,
                'category_id' => $attendanceCategory->id,
                'category_name' => $attendanceCategory->name
            ];
        }

        // Retourneer de gegevens als een JSON-respons
        return response()->json($data);
    }
}

