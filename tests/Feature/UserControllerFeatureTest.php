<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Arrange
        User::factory()->count(5)->create();

        // Act
        $response = $this->get(route('users.index'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }

    public function testCreate()
    {
        // Act
        $response = $this->get(route('users.create'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.create');
        $response->assertViewHas('user');
    }

    public function testStore()
    {
        // Arrange
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            // Add other required fields based on User::$rules
        ];

        // Act
        $response = $this->post(route('users.store'), $data);

        // Assert
        $this->assertCount(1, User::all());
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User created successfully.');
    }

    public function testShow()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->get(route('users.show', $user->id));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user');
    }

    public function testEdit()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->get(route('users.edit', $user->id));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user');
    }

    public function testUpdate()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            // Add other required fields based on User::$rules
        ];

        // Act
        $response = $this->put(route('users.update', $user->id), $data);

        // Assert
        $user->refresh();
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User updated successfully');
    }

    public function testDestroy()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->delete(route('users.destroy', $user->id));

        // Assert
        $this->assertCount(0, User::all());
        $this->assertDeleted($user);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User deleted successfully');
    }

}
