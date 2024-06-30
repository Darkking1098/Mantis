<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\ProtectedPageSeeder;

return new class extends Migration
{
    private const TABLE = "queries";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->dateTime('raised_at')->useCurrent();
        });

        $seeder = new ProtectedPageSeeder();
        $seeder->run([
            [
                "group_id" => 1,
                "title" => "View Queries",
                "uri" => "admin/query",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 1,
                "title" => "View Query",
                "uri" => "admin/query/{query}",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 1,
                "uri" => "admin/query/{query}/delete",
                "title" => "Delete Query",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ]
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
