<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\ProtectedPageGroupSeeder;

return new class extends Migration
{
    private const TABLE = "protected_page_groups";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->integer('sort_order')->nullable();
            $table->boolean('status')->default(true);
        });

        $seeder = new ProtectedPageGroupSeeder();
        $seeder->run([
            ['title' => 'Others', 'sort_order' => 999, 'status' => true]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
