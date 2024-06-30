<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\ProtectedPageGroupSeeder;
use Mantis\database\seeders\ProtectedPageSeeder;
use Mantis\database\seeders\WebPageSeeder;

return new class extends Migration
{
    private const TABLE = "web_pages";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keyword')->nullable();
            $table->text('other_meta')->nullable();
            $table->integer('load_count')->default(0);
            $table->tinyInteger('status')->default(true);
        });

        $seeder = new ProtectedPageGroupSeeder();
        $seeder->run([
            ['title' => 'Manage Web Pages', 'sort_order' => 2, 'status' => true]
        ]);

        $seeder = new ProtectedPageSeeder();
        $seeder->run([
            [
                "group_id" => 3,
                "uri" => "admin/webpage",
                "title" => "View Webpages",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/webpage/create",
                "title" => "Create Webpage",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/webpage/check",
                "title" => "Check WebPage Exists",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/webpage/{webpage}",
                "title" => "View Webpage",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/webpage/{webpage}/update",
                "title" => "Update Webpage",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/webpage/{webpage}/toggle",
                "title" => "Toggle Webpage Status",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 3,
                "uri" => "admin/webpage/{webpage}/delete",
                "title" => "Delete Webpage",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ]
        ]);

        $seeder = new WebPageSeeder();
        $seeder->run([
            [
                'slug' => '*',
                'title' => 'Universal Title',
                'description' => 'Universal Description',
                'keyword' => 'Universal Keywords',
                'load_count' => 0,
                'status' => true,
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
