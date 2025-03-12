<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Company\Models\Company;
use Modules\Employee\Models\Employee;

class CompanyEmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_company_with_multiple_employees()
    {
        // Create a company
        $company = Company::create([
            'name' => 'Tech Corp',
            'address' => '123 Main Street',
        ]);

        // Attach multiple employees to the company
        $employees = Employee::factory()->count(3)->create([
            'company_id' => $company->id,
        ]);

        // Retrieve the employees via Eloquent
        $retrievedEmployees = $company->employees;

        // Assertions
        $this->assertCount(3, $retrievedEmployees);
        $this->assertEquals($employees->pluck('id')->sort()->values(), $retrievedEmployees->pluck('id')->sort()->values());
    }
}
