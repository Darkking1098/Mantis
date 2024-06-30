<?php

namespace Mantis\database\seeders;

use Illuminate\Database\Seeder;
use Mantis\Models\Query;

class QuerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($data): void
    {
        foreach ($data as $group) {
            Query::create($group);
        }
    }
}
