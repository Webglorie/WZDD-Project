<?php


use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use App\Http\Controllers\EquipmentController;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class EquipmentControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test de index methode van de EquipmentController.
     *
     * @return void
     */
    public function testIndex()
    {
        // Arrange
        Equipment::factory()->count(3)->create();
        $controller = new EquipmentController();

        // Act
        $response = $controller->index();

        // Assert
        $this->assertEquals('equipment.index', $response->getName());
        $this->assertArrayHasKey('equipment', $response->getData());
        $this->assertCount(3, $response->getData()['equipment']);
    }

    /**
     * Test de create methode van de EquipmentController.
     *
     * @return void
     */
    public function testCreate()
    {
        // Arrange
        $controller = new EquipmentController();

        // Act
        $response = $controller->create();

        // Assert
        $this->assertEquals('equipment.create', $response->getName());
    }

    /**
     * Test de store methode van de EquipmentController.
     *
     * @return void
     */
    public function testStore()
    {
        // Arrange
        $request = new Request([
            'category_id' => 1,
            'title' => 'Test Equipment',
            'ultimo_id' => 'ABC123',
            'status' => EquipmentStatus::AVAILABLE,
            'condition' => EquipmentCondition::GOOD,
        ]);
        $controller = new EquipmentController();

        // Act
        $response = $controller->store($request);

        // Assert
        $this->assertNotNull(Equipment::where('title', 'Test Equipment')->first());
        $this->assertEquals(route('equipment.index'), $response->getTargetUrl());
    }

    /**
     * Test de edit methode van de EquipmentController.
     *
     * @return void
     */
    public function testEdit()
    {
        // Arrange
        $equipment = Equipment::factory()->create();
        $controller = new EquipmentController();

        // Act
        $response = $controller->edit($equipment->id);

        // Assert
        $this->assertEquals('equipment.edit', $response->getName());
        $this->assertArrayHasKey('equipment', $response->getData());
        $this->assertEquals($equipment->id, $response->getData()['equipment']->id);
    }

}
