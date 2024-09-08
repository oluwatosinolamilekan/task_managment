<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test that a task can be created successfully.
     */
    public function test_task_can_be_created()
    {

        $url = env('PROCESS_TASK_URL', 'http://127.0.0.1:5000');

        Http::fake([
            $url . '/process-task' => Http::response(['message' => 'Task Test Task has been successfully processed by Python'], 200),
        ]);

        // Send a POST request to create a task
        $response = $this->post('/tasks', [
            'name' => 'Test Task',
            'description' => 'This is a test task.',
        ]);

        // Assert that the task is in the database
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'description' => 'This is a test task.',
        ]);

        // Assert that the Python service was called and returned the expected message
        $response->assertRedirect('/');
        $response->assertSessionHas('message', 'Task Test Task has been successfully processed by Python');
    }

    /**
     * Test that a task cannot be created without a name.
     */
    public function test_task_requires_name()
    {
        // Send a POST request without a name
        $response = $this->post('/tasks', [
            'description' => 'This task has no name.',
        ]);

        // Assert that the validation error is returned
        $response->assertSessionHasErrors('name');
    }

    /**
     * Test that a task cannot be created without a description.
     */
    public function test_task_requires_description()
    {
        // Send a POST request without a description
        $response = $this->post('/tasks', [
            'name' => 'Nameless Description',
        ]);

        // Assert that the validation error is returned
        $response->assertSessionHasErrors('description');
    }

    /**
     * Test that tasks can be listed.
     */
    public function test_tasks_can_be_listed()
    {
        // Create a couple of tasks
        Task::factory()->create(['name' => 'Task One', 'description' => 'First task']);
        Task::factory()->create(['name' => 'Task Two', 'description' => 'Second task']);

        // Send a GET request to fetch tasks
        $response = $this->get('/tasks');

        // Assert that the tasks are shown on the page
        $response->assertStatus(200);
        $response->assertSee('Task One');
        $response->assertSee('Task Two');
    }
}
