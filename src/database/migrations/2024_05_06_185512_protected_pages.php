<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\ProtectedPageGroupSeeder;
use Mantis\database\seeders\ProtectedPageSeeder;

return new class extends Migration
{
    private const TABLE = "protected_pages";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('protected_page_groups')->onDelete('restrict');
            $table->string('uri', 255)->unique();
            $table->string('title', 255);
            $table->json('inner_permits')->default('[]');
            $table->string('panel')->default('admin');
            $table->boolean('visible')->default(false);
            $table->boolean('permission_required')->default(true);
            $table->boolean('status')->default(true);
        });

        $seeder = new ProtectedPageGroupSeeder();
        $seeder->run([
            ['title' => 'Protected Pages', 'sort_order' => 1, 'status' => true]
        ]);

        $seeder = new ProtectedPageSeeder();
        $seeder->run([
            [
                "group_id" => 2,
                "title" => "View Pages",
                "uri" => "admin/page",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Create Page",
                "uri" => "admin/page/create",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "View Page",
                "uri" => "admin/page/{page}",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Update Page",
                "uri" => "admin/page/{page}/update",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Toggle Page Status",
                "uri" => "admin/page/{page}/toggle",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Delete Page",
                "uri" => "admin/page/{page}/delete",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "View Groups",
                "uri" => "admin/page/group",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Arrange Groups",
                "uri" => "admin/page/group/arrange",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Create Group",
                "uri" => "admin/page/group/create",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "View Group",
                "uri" => "admin/page/group/{group}",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Update Group",
                "uri" => "admin/page/group/{group}/update",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Toggle Group",
                "uri" => "admin/page/group/{group}/toggle",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 2,
                "title" => "Delete Group",
                "uri" => "admin/page/group/{group}/delete",
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
