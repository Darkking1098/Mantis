<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\ProtectedPageSeeder;
use Mantis\database\seeders\WebUriSeeder;

return new class extends Migration
{
    private const TABLE = 'web_uris';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('uri')->unique();
            $table->enum('state', ['dev', 'prod'])->default('dev');
            $table->boolean('status')->default(true);
            $table->boolean('track')->default(true);
        });

        $seeder = new ProtectedPageSeeder();
        $seeder->run([
            [
                "group_id" => 3,
                "uri" => "admin/weburi",
                "title" => "View Weburis",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/weburi/create",
                "title" => "Create Weburi",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/weburi/check",
                "title" => "Check Weburi Exists",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/weburi/{weburi}",
                "title" => "View Weburi",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/weburi/{weburi}/update",
                "title" => "Update Weburi",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/weburi/{weburi}/toggle",
                "title" => "Toggle Weburi Status",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/weburi/{weburi}/delete",
                "title" => "Delete Weburi",
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
