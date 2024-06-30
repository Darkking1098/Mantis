<?php

namespace Mantis\database\seeders;

use Illuminate\Database\Seeder;
use Mantis\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($data): void
    {
        foreach ($data as $group) {
            $emp = new Employee($group);
            $emp->save();
        }
    }
}
