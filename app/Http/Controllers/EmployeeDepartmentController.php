<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDepartment;
use App\Repositories\Interfaces\EmployeeDepartmentRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeDepartmentController extends Controller
{
    private $employeeDepartmentRepository;

    public function __construct(EmployeeDepartmentRepositoryInterface $employeeDepartmentRepository)
    {
        $this->employeeDepartmentRepository = $employeeDepartmentRepository;
    }

    public function index()
    {
        $employeeDepartments = $this->employeeDepartmentRepository->getAll();

        return view('employee-departments.index', compact('employeeDepartments'));
    }

    public function create()
    {
        $employeeDepartment = $this->employeeDepartmentRepository->makeModel();
        $i = 0;

        return view('employee-departments.create', compact('employeeDepartment'));
    }

    public function store(Request $request)
    {
        $request->validate($this->employeeDepartmentRepository->getValidationRules());

        $employeeDepartment = $this->employeeDepartmentRepository->create($request->all());

        return redirect()->back()
            ->with('success', 'De nieuwe afdeling is succesvol toegevoegd!');
    }

    public function show($id)
    {
        $employeeDepartment = $this->employeeDepartmentRepository->find($id);

        return view('employee-departments.show', compact('employeeDepartment'));
    }

    public function edit($id)
    {
        $employeeDepartment = $this->employeeDepartmentRepository->find($id);

        return view('employee-departments.edit', compact('employeeDepartment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->employeeDepartmentRepository->getValidationRules());

        $employeeDepartment = $this->employeeDepartmentRepository->update($id, $request->all());

        return redirect()->route('employee-departments.index')
            ->with('success', 'EmployeeDepartment updated successfully');
    }

    public function destroy($id)
    {
        $this->employeeDepartmentRepository->delete($id);

        return redirect()->route('employee-departments.index')
            ->with('success', 'EmployeeDepartment deleted successfully');
    }

    public function getDepartmentsApi()
    {
        $departments = EmployeeDepartment::all();

        return response()->json([
            'departments' => $departments,
        ]);
    }
}
