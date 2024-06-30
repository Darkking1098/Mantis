<?php

namespace Mantis\database\seeders;

use Illuminate\Database\Seeder;
use Mantis\Models\WebPage;

class WebPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($data): void
    {
        foreach ($data as $group) {
            WebPage::create($group);
        }
    }
}
