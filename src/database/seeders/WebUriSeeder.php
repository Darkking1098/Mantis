<?php

namespace Mantis\database\seeders;

use Illuminate\Database\Seeder;
use Mantis\Models\WebUri;

class WebUriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($data): void
    {
        foreach ($data as $group) {
            WebUri::create($group);
        }
    }
}
