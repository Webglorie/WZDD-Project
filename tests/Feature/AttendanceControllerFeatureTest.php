<?php

namespace Tests\Feature;

use App\Models\AttendanceCategory;
use App\Models\AttendanceEmployee;
use App\Models\EmployeeDepartment;
use App\Models\WeekSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class AttendanceControllerFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Arrange
        $currentDay = Carbon::now()->format('l');
        $departments = EmployeeDepartment::factory()->count(3)->create();
        $categories = AttendanceCategory::factory()->count(5)->create();
        $employees = AttendanceEmployee::factory()->count(10)->has(WeekSchedule::factory())->create();

        // Act
        $response = $this->get(route('attendance.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('attendance.index');
        $response->assertViewHasAll(['categories', 'employeeSchedules', 'departments']);
        // Add more assertions for specific data if necessary
    }

    public function testUpdateSchedule()
    {
        // Arrange
        $employee = AttendanceEmployee::factory()->create();
        $weekSchedule = WeekSchedule::factory()->create(['employee_id' => $employee->id]);
        $newScheduleData = [
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
        ];
        $requestData = [
            'schedule' => json_encode($newScheduleData),
        ];

        // Act
        $response = $this->post(route('attendance.updateSchedule', $employee->id), $requestData);

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Schedule updated successfully']);
        $this->assertEquals(json_encode($newScheduleData), $weekSchedule->refresh()->schedule);
    }

    public function testStore()
    {
        // Arrange
        $department = EmployeeDepartment::factory()->create();
        $requestData = [
            'employee_name' => $this->faker->name,
            'department_id' => $department->id,
        ];

        // Act
        $response = $this->post(route('attendance.store'), $requestData);

        // Assert
        $response->assertStatus(200);
        $response->assertJson($requestData);
        $this->assertDatabaseHas('attendance_employees', ['name' => $requestData['employee_name'], 'department_id' => $department->id]);
        $this->assertDatabaseHas('week_schedules', ['employee_id' => $response->json('id')]);
    }

    public function testDestroy()
    {
        // Arrange
        $employee = AttendanceEmployee::factory()->create();

        // Act
        $response = $this->delete(route('attendance.destroy', $employee->id));

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['message' => $employee->toArray()]);
        $this->assertDeleted($employee);
    }

    public function testGetCategories()
    {
        // Arrange
        $categories = AttendanceCategory::factory()->count(5)->create();

        // Act
        $response = $this->get(route('attendance.getCategories'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['data' => $categories->toArray()]);
    }

    public function testGetAttendanceToday()
    {
        // Arrange
        $today = strtolower(date('l'));
        $employee1 = AttendanceEmployee::factory()->create();
        $employee2 = AttendanceEmployee::factory()->create();
        $weekSchedule1 = WeekSchedule::factory()->create(['employee_id' => $employee1->id, 'schedule' => json_encode([$today => 1])]);
        $weekSchedule2 = WeekSchedule::factory()->create(['employee_id' => $employee2->id, 'schedule' => json_encode([$today => 2])]);
        $expectedResponse = [
            [
                'id' => $employee1->id,
                'name' => $employee1->name,
                'department_id' => $employee1->department_id,
                'department_name' => $employee1->department->name,
                'category_id' => 1,
                'category_name' => AttendanceCategory::find(1)->name,
            ],
            [
                'id' => $employee2->id,
                'name' => $employee2->name,
                'department_id' => $employee2->department_id,
                'department_name' => $employee2->department->name,
                'category_id' => 2,
                'category_name' => AttendanceCategory::find(2)->name,
            ],
        ];

        // Act
        $response = $this->get(route('attendance.getAttendanceToday'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }

}
