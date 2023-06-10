<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AttendanceScheduleOverrideRepositoryInterface;
use Illuminate\Http\Request;

class AttendanceScheduleOverrideController extends Controller
{
    private $attendanceScheduleOverrideRepository;

    public function __construct(AttendanceScheduleOverrideRepositoryInterface $attendanceScheduleOverrideRepository)
    {
        $this->attendanceScheduleOverrideRepository = $attendanceScheduleOverrideRepository;
    }

    public function index()
    {
        $overrides = $this->attendanceScheduleOverrideRepository->getAll();
        return view('overrides.index', compact('overrides'));
    }

    public function show($id)
    {
        $override = $this->attendanceScheduleOverrideRepository->getById($id);
        return view('overrides.show', compact('override'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'category_id' => 'required',
        ]);

        $this->attendanceScheduleOverrideRepository->create($data);

        return redirect()->route('overrides.index')->with('success', 'Schedule override created successfully.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'category_id' => 'required',
        ]);

        $this->attendanceScheduleOverrideRepository->update($id, $data);

        return redirect()->route('overrides.index')->with('success', 'Schedule override updated successfully.');
    }

    public function destroy($id)
    {
        $this->attendanceScheduleOverrideRepository->delete($id);

        return redirect()->route('overrides.index')->with('success', 'Schedule override deleted successfully.');
    }
}
