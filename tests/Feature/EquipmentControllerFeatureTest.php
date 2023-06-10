<?php


use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use App\Http\Controllers\EquipmentController;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class EquipmentControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Feature test voor het ophalen van de uitrustingsindexpagina.
     *
     * @return void
     */
    public function testIndex()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        Equipment::factory()->count(3)->create();

        // Act
        $response = $this->get(route('equipment.index'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('equipment.index');
        $response->assertViewHas('equipment');
        $this->assertCount(3, $response->viewData('equipment'));
    }

    /**
     * Feature test voor het maken van een nieuwe uitrusting.
     *
     * @return void
     */
    public function testStore()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = EquipmentCategory::factory()->create();
        $equipmentData = [
            'category_id' => $category->id,
            'title' => 'Test Equipment',
            'ultimo_id' => 'ABC123',
            'status' => EquipmentStatus::AVAILABLE,
            'condition' => EquipmentCondition::GOOD,
        ];

        // Act
        $response = $this->post(route('equipment.store'), $equipmentData);

        // Assert
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('equipment.index'));
        $this->assertDatabaseHas('equipment', $equipmentData);
    }

    /**
     * Feature test voor het maken van een nieuwe uitrusting.
     *
     * @return void
     */
    public function testCreateEquipment()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Roep de create methode aan
        $response = $controller->create();

        // Assert de response
        $response->assertStatus(200);
        $response->assertViewIs('equipment.create');
    }

    /**
     * Feature test voor het opslaan van een nieuwe uitrusting.
     *
     * @return void
     */
    public function testStoreEquipment()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een nieuwe uitrusting aan
        $equipmentData = Equipment::factory()->make();

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Mock het request met de benodigde data
        $response = $this->post(route('equipment.store'), $equipmentData->toArray());

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseHas('equipment', $equipmentData->toArray());
    }

    /**
     * Feature test voor het bewerken van een uitrusting.
     *
     * @return void
     */
    public function testEditEquipment()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een uitrusting
        $equipment = Equipment::factory()->create();

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Roep de edit methode aan
        $response = $controller->edit($equipment->id);

        // Assert de response
        $response->assertStatus(200);
        $response->assertViewIs('equipment.edit');
        $response->assertViewHas('equipment', $equipment);
    }

    /**
     * Feature test voor het bijwerken van een uitrusting.
     *
     * @return void
     */
    public function testUpdateEquipment()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een bestaande uitrusting
        $equipment = Equipment::factory()->create();

        // Maak nieuwe gegevens voor de uitrusting
        $newEquipmentData = Equipment::factory()->make();

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Mock het request met de bijgewerkte gegevens
        $response = $this->put(route('equipment.update', $equipment->id), $newEquipmentData->toArray());

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseHas('equipment', $newEquipmentData->toArray());
        $this->assertDatabaseMissing('equipment', $equipment->toArray());
    }

    /**
     * Feature test voor het verwijderen van een uitrusting.
     *
     * @return void
     */
    public function testDestroyEquipment()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een bestaande uitrusting
        $equipment = Equipment::factory()->create();

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Roep de destroy methode aan
        $response = $controller->destroy($equipment->id);

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseMissing('equipment', $equipment->toArray());
    }

    /**
     * Feature test voor het wijzigen van de status van een uitrusting.
     *
     * @return void
     */
    public function testChangeStatus()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een bestaande uitrusting
        $equipment = Equipment::factory()->create();

        // Maak een nieuwe status voor de uitrusting
        $newStatus = EquipmentStatus::AVAILABLE;

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Mock het request met de nieuwe status
        $response = $this->put(route('equipment.change-status', $equipment->id), ['new_status' => $newStatus]);

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseHas('equipment', ['id' => $equipment->id, 'status' => $newStatus]);
    }

    /**
     * Feature test voor het wijzigen van de conditie van een uitrusting.
     *
     * @return void
     */
    public function testChangeCondition()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een bestaande uitrusting
        $equipment = Equipment::factory()->create();

        // Maak een nieuwe conditie voor de uitrusting
        $newCondition = EquipmentCondition::GOOD;

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Mock het request met de nieuwe conditie
        $response = $this->put(route('equipment.change-condition', $equipment->id), ['new_condition' => $newCondition]);

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseHas('equipment', ['id' => $equipment->id, 'condition' => $newCondition]);
    }

    /**
     * Feature test voor het toevoegen van een notitie aan een uitrusting.
     *
     * @return void
     */
    public function testAddNote()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een bestaande uitrusting
        $equipment = Equipment::factory()->create();

        // Maak nieuwe notitiegegevens
        $noteData = [
            'content' => 'Dit is een notitie.',
        ];

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Mock het request met de notitiegegevens
        $response = $this->post(route('equipment.add-note', $equipment->id), $noteData);

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseHas('equipment_notes', ['content' => $noteData['content']]);
    }

    /**
     * Feature test voor het lenen van een uitrusting.
     *
     * @return void
     */
    public function testBorrowEquipment()
    {
        // Creëer en log in als een gebruiker
        $user = User::factory()->create();
        $this->actingAs($user);

        // Maak een bestaande uitrusting
        $equipment = Equipment::factory()->create();

        // Maak nieuwe geleende uitrustinggegevens
        $borrowedEquipmentData = [
            'borrower' => 'John Doe',
            'borrowed_date_begin' => Carbon::now()->toDateString(),
            'borrowed_date_end' => Carbon::now()->addWeek()->toDateString(),
            'ultimo_ticket_number' => 'ABC123',
        ];

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Mock het request met de geleende uitrustinggegevens
        $response = $this->post(route('equipment.borrow', $equipment->id), $borrowedEquipmentData);

        // Assert de response
        $response->assertRedirect(route('equipment.index'));

        // Assert de database
        $this->assertDatabaseHas('borrowed_equipment', ['borrower' => $borrowedEquipmentData['borrower']]);
    }

    /**
     * Feature test voor het ophalen van beschikbare uitrusting.
     *
     * @return void
     */
    public function testGetAvailableEquipment()
    {
        // Maak een bestaande categorie
        $category = Category::factory()->create();

        // Maak enkele uitrustingen
        $equipment1 = Equipment::factory()->create([
            'category_id' => $category->id,
            'status' => EquipmentStatus::AVAILABLE,
            'condition' => EquipmentCondition::GOOD,
        ]);
        $equipment2 = Equipment::factory()->create([
            'category_id' => $category->id,
            'status' => EquipmentStatus::AVAILABLE,
            'condition' => EquipmentCondition::GOOD,
        ]);
        $equipment3 = Equipment::factory()->create([
            'category_id' => $category->id,
            'status' => EquipmentStatus::AVAILABLE,
            'condition' => EquipmentCondition::GOOD,
        ]);

        // Maak een instantie van de controller
        $controller = new EquipmentController();

        // Roep de getAvailableEquipment methode aan
        $availableEquipment = $controller->getAvailableEquipment($category->id);

        // Assert de beschikbare uitrustingen
        $this->assertTrue($availableEquipment->contains($equipment1));
        $this->assertTrue($availableEquipment->contains($equipment2));
        $this->assertFalse($availableEquipment->contains($equipment3));
    }
}
