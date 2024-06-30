<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\ProtectedPageSeeder;
use Mantis\database\seeders\RoleSeeder;
use Mantis\Models\Employee;

return new class extends Migration
{
    private const TABLE = 'roles';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('permissions')->default('[]');
        });

        $seeder = new ProtectedPageSeeder();
        $seeder->run([
            [
                "group_id" => 4,
                "uri" => "admin/role",
                "title" => "View Roles",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/role/create",
                "title" => "Create Role",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/role/check",
                "title" => "Check Role Username Exists",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/role/{role}",
                "title" => "View Role",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/role/{role}/update",
                "title" => "Update Role",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/role/{role}/toggle",
                "title" => "Toggle Role Status",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/role/{role}/delete",
                "title" => "Delete Role",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ]
        ]);

        $seeder = new RoleSeeder();
        $seeder->run([
            [
                'title' => 'Employee',
                'description' => 'Standard employee role with basic permissions. Mostly for viewing data.',
                'permissions' => []
            ],
            [
                'title' => 'Developer',
                'description' => 'Developers are responsible for building, maintaining, and enhancing the website\'s technical infrastructure. They work on coding, debugging, and implementing new features or functionality.',
                'permissions' => ['*']
            ]
        ]);

        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('id')->default(1);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
        });

        Employee::where('username', 'developer')->first()->update(['role_id' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
        Schema::dropIfExists(self::TABLE);
    }
};
