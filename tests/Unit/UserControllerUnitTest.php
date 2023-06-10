<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerUnitTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Arrange
        User::factory()->count(5)->create();
        $controller = new UserController();

        // Act
        $response = $controller->index();

        // Assert
        $users = User::paginate();
        $expectedView = view('users.index', compact('users'))->with('i', (request()->input('page', 1) - 1) * $users->perPage());
        $this->assertEquals($expectedView, $response);
    }

    public function testCreate()
    {
        // Arrange
        $controller = new UserController();

        // Act
        $response = $controller->create();

        // Assert
        $user = new User();
        $expectedView = view('users.create', compact('user'));
        $this->assertEquals($expectedView, $response);
    }

    public function testStore()
    {
        // Arrange
        $controller = new UserController();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            // Add other required fields based on User::$rules
        ];
        $request = new Request($data);

        // Act
        $response = $controller->store($request);

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
        $controller = new UserController();

        // Act
        $response = $controller->show($user->id);

        // Assert
        $expectedView = view('users.show', compact('user'));
        $this->assertEquals($expectedView, $response);
    }

    public function testEdit()
    {
        // Arrange
        $user = User::factory()->create();
        $controller = new UserController();

        // Act
        $response = $controller->edit($user->id);

        // Assert
        $expectedView = view('users.edit', compact('user'));
        $this->assertEquals($expectedView, $response);
    }

    public function testUpdate()
    {
        // Arrange
        $user = User::factory()->create();
        $controller = new UserController();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            // Add other required fields based on User::$rules
        ];
        $request = new Request($data);

        // Act
        $response = $controller->update($request, $user);

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
        $controller = new UserController();

        // Act
        $response = $controller->destroy($user->id);

        // Assert
        $this->assertCount(0, User::all());
        $this->assertDeleted($user);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User deleted successfully');
    }

}
