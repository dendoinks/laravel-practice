<?php

namespace Modules\Employee\Console;

use Illuminate\Console\Command;
use Modules\Employee\Models\Employee;
use Modules\Company\Models\Company;

class SeedEmployees extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'employees:seed';

    /**
     * The console command description.
     */
    protected $description = 'Seed sample employee data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding employees...');

        // Create a test company if one does not exist
        $company = Company::firstOrCreate(
            ['name' => 'Tech Corp'],
            ['address' => '123 Main Street']
        );

        $employees = [];

        for ($i = 1; $i <= 5; $i++) {
            $employee = $company->employees()->create([
                'name' => "Employee $i",
                'email' => "employee{$i}@example.com",
                'position' => 'Developer'
            ]);

            $employees[] = $employee;
        }

        // Display a formatted table of seeded employees
        $this->table(
            ['ID', 'Name', 'Email', 'Position', 'Company'],
            collect($employees)->map(fn($e) => [$e->id, $e->name, $e->email, $e->position, $e->company->name])->toArray()
        );

        $this->info('Employee seeding complete!');
    }
}
