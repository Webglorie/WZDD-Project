<?php

use App\Enums\EquipmentStatus;
use App\Http\Controllers\BorrowedEquipmentController;
use App\Models\BorrowedEquipment;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class BorrowedEquipmentControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unit test voor de index methode.
     *
     * @return void
     */
    public function testIndex()
    {
        // Maak testgegevens
        BorrowedEquipment::factory()->count(5)->create();
        Equipment::factory()->count(10)->create();

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de index methode aan
        $response = $controller->index();

        // Assert de response
        $response->assertViewIs('borrowed-equipment.index');
        $response->assertViewHas(['borrowedEquipments', 'allEquipment']);
    }

    /**
     * Unit test voor de create methode.
     *
     * @return void
     */
    public function testCreate()
    {
        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de create methode aan
        $response = $controller->create();

        // Assert de response
        $response->assertViewIs('borrowed-equipment.create');
        $response->assertViewHas(['borrowedEquipment', 'allEquipment']);
    }

    /**
     * Unit test voor de store methode.
     *
     * @return void
     */
    public function testStore()
    {
        // Maak een nieuw geleend materiaal object
        $borrowedEquipmentData = BorrowedEquipment::factory()->make();

        // Mock het request met de benodigde data
        $request = Request::create('/borrowed-equipments', 'POST', $borrowedEquipmentData->toArray());

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de store methode aan
        $response = $controller->store($request);

        // Assert de response
        $response->assertRedirect(route('borrowed-equipments.index'));
        $response->assertSessionHas('success');

        // Assert de database
        $this->assertDatabaseHas('borrowed_equipments', $borrowedEquipmentData->toArray());
        $this->assertEquals(EquipmentStatus::RESERVED, $borrowedEquipmentData->equipment->refresh()->status);
    }

    /**
     * Unit test voor de show methode.
     *
     * @return void
     */
    public function testShow()
    {
        // Maak een geleend materiaal object
        $borrowedEquipment = BorrowedEquipment::factory()->create();

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de show methode aan
        $response = $controller->show($borrowedEquipment->id);

        // Assert de response
        $response->assertViewIs('borrowed-equipment.show');
        $response->assertViewHas('borrowedEquipment');
    }

    /**
     * Unit test voor de edit methode.
     *
     * @return void
     */
    public function testEdit()
    {
        // Maak een geleend materiaal object
        $borrowedEquipment = BorrowedEquipment::factory()->create();

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de edit methode aan
        $response = $controller->edit($borrowedEquipment->id);

        // Assert de response
        $response->assertViewIs('borrowed-equipment.edit');
        $response->assertViewHas('borrowedEquipment');
    }

    /**
     * Unit test voor de update methode.
     *
     * @return void
     */
    public function testUpdate()
    {
        // Maak een geleend materiaal object
        $borrowedEquipment = BorrowedEquipment::factory()->create();

        // Genereer nieuwe data voor het geleend materiaal object
        $newData = BorrowedEquipment::factory()->make();

        // Mock het request met de nieuwe data
        $request = Request::create('/borrowed-equipments/'.$borrowedEquipment->id, 'POST', $newData->toArray());

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de update methode aan
        $response = $controller->update($request, $borrowedEquipment);

        // Assert de response
        $response->assertRedirect(route('borrowed-equipments.index'));
        $response->assertSessionHas('success');

        // Assert de database
        $this->assertDatabaseHas('borrowed_equipments', $newData->toArray());
    }

    /**
     * Unit test voor de destroy methode.
     *
     * @return void
     */
    public function testDestroy()
    {
        // Maak een geleend materiaal object
        $borrowedEquipment = BorrowedEquipment::factory()->create();

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de destroy methode aan
        $response = $controller->destroy($borrowedEquipment->id);

        // Assert de response
        $response->assertRedirect(route('borrowed-equipments.index'));
        $response->assertSessionHas('success');

        // Assert de database
        $this->assertDatabaseMissing('borrowed_equipments', [
            'id' => $borrowedEquipment->id
        ]);
    }
}
