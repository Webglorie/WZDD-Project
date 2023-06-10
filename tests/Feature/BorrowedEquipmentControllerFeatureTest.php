<?php

use App\Enums\EquipmentStatus;
use App\Http\Controllers\BorrowedEquipmentController;
use App\Models\BorrowedEquipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BorrowedEquipmentControllerFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Feature test voor het maken van geleend materiaal.
     *
     * @return void
     */
    public function testCreateBorrowedEquipment()
    {
        // Maak een gebruiker
        $user = User::factory()->create();

        // Log in als de gebruiker
        $this->actingAs($user);

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de create methode aan
        $response = $controller->create();

        // Assert de response
        $response->assertStatus(200);
        $response->assertViewIs('borrowed-equipment.create');
        $response->assertViewHas(['borrowedEquipment', 'allEquipment']);
    }

    /**
     * Feature test voor het opslaan van geleend materiaal.
     *
     * @return void
     */
    public function testStoreBorrowedEquipment()
    {
        // Maak een gebruiker
        $user = User::factory()->create();

        // Log in als de gebruiker
        $this->actingAs($user);

        // Maak een geleend materiaal object
        $borrowedEquipmentData = BorrowedEquipment::factory()->make();

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Mock het request met de benodigde data
        $response = $this->post(route('borrowed-equipments.store'), $borrowedEquipmentData->toArray());

        // Assert de response
        $response->assertRedirect(route('borrowed-equipments.index'));
        $response->assertSessionHas('success');

        // Assert de database
        $this->assertDatabaseHas('borrowed_equipments', $borrowedEquipmentData->toArray());
        $this->assertEquals(EquipmentStatus::RESERVED, $borrowedEquipmentData->equipment->refresh()->status);
    }

    /**
     * Feature test voor het bewerken van geleend materiaal.
     *
     * @return void
     */
    public function testEditBorrowedEquipment()
    {
        // Maak een gebruiker
        $user = User::factory()->create();

        // Log in als de gebruiker
        $this->actingAs($user);

        // Maak een geleend materiaal object
        $borrowedEquipment = BorrowedEquipment::factory()->create();

        // Maak een instantie van de controller
        $controller = new BorrowedEquipmentController();

        // Roep de edit methode aan
        $response = $controller->edit($borrowedEquipment->id);

        // Assert de response
        $response->assertStatus(200);
        $response->assertViewIs('borrowed-equipment.edit');
        $response->assertViewHas('borrowedEquipment');
    }

    /**
     * Feature test voor het bijwerken van geleend materiaal.
     *
     * @return void
     */
    public function testUpdateBorrowedEquipment()
    {
        // Maak een gebruiker
        $user = User::factory()->create();

        // Log in als de gebruiker
        $this->actingAs($user);

        // Maak een geleend materiaal object
        $borrowedEquipment = BorrowedEquipment::factory()->create();

        // Genereer nieuwe data voor het geleend materiaal object
        $newData = BorrowedEquipment::factory()->make();

        // Mock het request met de nieuwe data
        $response = $this->put(route('borrowed-equipments.update', $borrowedEquipment->id), $newData->toArray());

        // Assert de response
        $response->assertRedirect(route('borrowed-equipments.index'));
        $response->assertSessionHas('success');

        // Assert de database
        $this->assertDatabaseHas('borrowed_equipments', $newData->toArray());
    }

    /**
     * Feature test voor het verwijderen van geleend materiaal.
     *
     * @return void
     */
    public function testDeleteBorrowedEquipment()
    {
        // Maak een gebruiker
        $user = User::factory()->create();

        // Log in als de gebruiker
        $this->actingAs($user);

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
