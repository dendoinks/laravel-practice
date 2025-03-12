namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Employee\Models\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate'); // Ensure the database is migrated before each test
    }

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

        $found = Employee::where('id', $employee->id)->first();

        $this->assertNotNull($found);
        $this->assertEquals($employee->id, $found->id);
    }
}
