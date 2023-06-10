<?php


use App\Http\Controllers\AgendaItemController;
use App\Models\AgendaItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class AgendaItemControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexWithoutStatus()
    {
        // Arrange
        AgendaItem::factory()->count(5)->create();
        $controller = new AgendaItemController();

        // Act
        $response = $controller->index(new Request());

        // Assert
        $response->assertViewIs('agenda-item.index');
        $response->assertViewHas('agendaItems');
        $this->assertCount(5, $response->getData()->agendaItems);
    }

    public function testIndexWithStatus()
    {
        // Arrange
        $agendaItem1 = AgendaItem::factory()->create(['status' => 'Pending']);
        $agendaItem2 = AgendaItem::factory()->create(['status' => 'Completed']);
        $controller = new AgendaItemController();

        // Act
        $response = $controller->index(new Request(), 'pending');

        // Assert
        $response->assertViewIs('agenda-item.index');
        $response->assertViewHas('agendaItems');
        $this->assertCount(1, $response->getData()->agendaItems);
        $this->assertEquals($agendaItem1->id, $response->getData()->agendaItems[0]->id);
    }

    public function testCreate()
    {
        // Arrange
        $controller = new AgendaItemController();

        // Act
        $response = $controller->create();

        // Assert
        $response->assertViewIs('agenda-item.create');
        $response->assertViewHas('agendaItem');
    }

    public function testStore()
    {
        // Arrange
        $controller = new AgendaItemController();
        $data = [
            'title' => 'Test Agenda Item',
            'description' => 'Test Description',
            'date' => '2023-06-01',
            'time' => '09:00:00',
            'location' => 'Test Location',
            'status' => 'Pending',
        ];
        $request = new Request($data);

        // Act
        $response = $controller->store($request);

        // Assert
        $this->assertCount(1, AgendaItem::all());
        $this->assertDatabaseHas('agenda_items', ['title' => 'Test Agenda Item']);
        $response->assertRedirect(route('agenda-items.index'));
        $response->assertSessionHas('success', 'Agendapunt is toegevoegd.');
    }

    public function testEdit()
    {
        // Arrange
        $agendaItem = AgendaItem::factory()->create();
        $controller = new AgendaItemController();

        // Act
        $response = $controller->edit($agendaItem->id);

        // Assert
        $response->assertViewIs('agenda-item.edit');
        $response->assertViewHas('agendaItem');
        $this->assertEquals($agendaItem->id, $response->getData()->agendaItem->id);
    }

    public function testUpdate()
    {
        // Arrange
        $agendaItem = AgendaItem::factory()->create();
        $controller = new AgendaItemController();
        $data = [
            'title' => 'Updated Agenda Item',
            'description' => 'Updated Description',
            'date' => '2023-06-02',
            'time' => '10:00:00',
            'location' => 'Updated Location',
            'status' => 'Completed',
        ];
        $request = new Request($data);

        // Act
        $response = $controller->update($request, $agendaItem);

        // Assert
        $agendaItem->refresh();
        $this->assertEquals('Updated Agenda Item', $agendaItem->title);
        $this->assertEquals('Updated Description', $agendaItem->description);
        $this->assertEquals('2023-06-02 10:00:00', $agendaItem->time->format('Y-m-d H:i:s'));
        $this->assertEquals('Updated Location', $agendaItem->location);
        $this->assertEquals('Completed', $agendaItem->status);
        $response->assertRedirect(route('agenda-items.index'));
        $response->assertSessionHas('success', 'Agendapunt met id #'.$agendaItem->id.' succesvol gewijzigd');
    }

    public function testDestroy()
    {
        // Arrange
        $agendaItem = AgendaItem::factory()->create();
        $controller = new AgendaItemController();

        // Act
        $response = $controller->destroy($agendaItem->id);

        // Assert
        $this->assertCount(0, AgendaItem::all());
        $this->assertDeleted($agendaItem);
        $response->assertRedirect(route('agenda-items.index'));
        $response->assertSessionHas('success', 'Agendapunt met id #'.$agendaItem->id.' succesvol verwijderd');
    }

}
