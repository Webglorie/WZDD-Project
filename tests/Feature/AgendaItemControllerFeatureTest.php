<?php


use App\Models\AgendaItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgendaItemControllerFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndexWithoutStatus()
    {
        // Arrange
        AgendaItem::factory()->count(5)->create();

        // Act
        $response = $this->get('/agenda-items');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('agenda-item.index');
        $response->assertViewHas('agendaItems');
        $this->assertCount(5, $response->viewData('agendaItems'));
    }

    public function testIndexWithStatus()
    {
        // Arrange
        $agendaItem1 = AgendaItem::factory()->create(['status' => 'Pending']);
        $agendaItem2 = AgendaItem::factory()->create(['status' => 'Completed']);

        // Act
        $response = $this->get('/agenda-items/pending');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('agenda-item.index');
        $response->assertViewHas('agendaItems');
        $this->assertCount(1, $response->viewData('agendaItems'));
        $this->assertEquals($agendaItem1->id, $response->viewData('agendaItems')[0]->id);
    }

    public function testCreate()
    {
        // Act
        $response = $this->get('/agenda-items/create');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('agenda-item.create');
        $response->assertViewHas('agendaItem');
    }

    public function testStore()
    {
        // Arrange
        $data = [
            'title' => 'Test Agenda Item',
            'description' => 'Test Description',
            'date' => '2023-06-01',
            'time' => '09:00:00',
            'location' => 'Test Location',
            'status' => 'Pending',
        ];

        // Act
        $response = $this->post('/agenda-items', $data);

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

        // Act
        $response = $this->get('/agenda-items/'.$agendaItem->id.'/edit');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('agenda-item.edit');
        $response->assertViewHas('agendaItem');
        $this->assertEquals($agendaItem->id, $response->viewData('agendaItem')->id);
    }

    public function testUpdate()
    {
        // Arrange
        $agendaItem = AgendaItem::factory()->create();
        $data = [
            'title' => 'Updated Agenda Item',
            'description' => 'Updated Description',
            'date' => '2023-06-02',
            'time' => '10:00:00',
            'location' => 'Updated Location',
            'status' => 'Completed',
        ];

        // Act
        $response = $this->put('/agenda-items/'.$agendaItem->id, $data);

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

        // Act
        $response = $this->delete('/agenda-items/'.$agendaItem->id);

        // Assert
        $this->assertCount(0, AgendaItem::all());
        $this->assertDeleted($agendaItem);
        $response->assertRedirect(route('agenda-items.index'));
        $response->assertSessionHas('success', 'Agendapunt met id #'.$agendaItem->id.' succesvol verwijderd');
    }

}
