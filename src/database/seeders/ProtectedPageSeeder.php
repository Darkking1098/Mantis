<?php

namespace Mantis\database\seeders;

use Illuminate\Database\Seeder;
use Mantis\Models\ProtectedPage;

class ProtectedPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($data): void
    {
        foreach ($data as $group) {
            ProtectedPage::create($group);
        }
    }

    public function revert($data)
    {
        foreach ($data as $group) {
            ProtectedPage::where('uri', $group['uri'])->delete();
        }
    }
}
