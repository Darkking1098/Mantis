<?php

namespace Mantis\database\seeders;

use Illuminate\Database\Seeder;
use Mantis\Models\ProtectedPageGroup;

class ProtectedPageGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($data): void
    {
        foreach ($data as $group) {
            ProtectedPageGroup::create($group);
        }
    }
    public function revert($data)
    {
        foreach ($data as $group) {
            ProtectedPageGroup::where('title', $group['title'])->delete();
        }
    }
}
