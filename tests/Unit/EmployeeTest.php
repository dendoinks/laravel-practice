<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Employee\Models\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase; // Ensures a fresh DB for each test

    /** @test */
    public function it_can_create_an_employee()
    {
        $employee = Employee::create([
            'name' => 'Test Employee',
            'email' => 'test@example.com',
            'position' => 'Developer',
        ]);

        $this->assertDatabaseHas('employees', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function it_can_retrieve_an_employee()
    {
        $employee = Employee::factory()->create();

        $found = Employee::find($employee->id);

        $this->assertNotNull($found);
        $this->assertEquals($employee->id, $found->id);
    }
}
