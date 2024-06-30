<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantis\database\seeders\EmployeeSeeder;
use Mantis\database\seeders\ProtectedPageGroupSeeder;
use Mantis\database\seeders\ProtectedPageSeeder;
use Mantis\Helpers\Security\Encoder\OPENSSL;

return new class extends Migration
{
    private const TABLE = "employees";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->enum('gender', ['male', 'female', 'transgender']);
            $table->json('profile_image')->nullable();
            $table->json('banner_image')->nullable();
            $table->text('about')->nullable();
            $table->json('email')->nullable();
            $table->json('contact')->nullable();
            $table->json('address')->nullable();
            $table->bigInteger('salary');
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->dateTime('joined_at')->useCurrent();
        });

        $seeder = new ProtectedPageGroupSeeder();
        $seeder->run([
            ['title' => 'Our Employees', 'sort_order' => 3, 'status' => true]
        ]);

        $seeder = new ProtectedPageSeeder();
        $seeder->run([
            [
                "group_id" => 4,
                "uri" => "admin/employee",
                "title" => "View Employees",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/employee/create",
                "title" => "Create Employee",
                "panel" => "admin",
                "visible" => 1,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/employee/check",
                "title" => "Check Employee Username Exists",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/employee/{employee}",
                "title" => "View Employee",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/employee/{employee}/update",
                "title" => "Update Employee",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/employee/{employee}/toggle",
                "title" => "Toggle Employee Status",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 4,
                "uri" => "admin/employee/{employee}/delete",
                "title" => "Delete Employee",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 1,
                "uri" => "admin/profile",
                "title" => "View Profile",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ],
            [
                "group_id" => 1,
                "uri" => "admin/profile/update",
                "title" => "Update Profile",
                "panel" => "admin",
                "visible" => 0,
                "status" => 1,
            ]
        ]);

        $seeder = new EmployeeSeeder();
        $seeder->run([
            [
                "name" => "Ajay Kumar",
                "username" => "developer",
                "gender" => "male",
                "profile_image" => ["url" => "mantis/images/developer.jpg"],
                "banner_image" => ["url" => "mantis/images/developer_banner.jpg"],
                "about" => "Hey Buddy, I am more than a web developer; I am a digital architect with a focus on Laravel web development. I specialise in original and creative website design using React, Angular, HTML, CSS, JavaScript, Python, PHP, Vue.js, and WordPress. My every project is a showcase of my dedication to excellence. Collaborative by nature, I prioritise open communication and client-centricity to ensure that each client's vision is met. Join me on a journey of digital transformation where we will redefine possibilities and build the future of the web.",
                "email" => ["personal" => "8571884176", "family" => "8813861098", "company" => null],
                "contact" => ["personal" => "ajaykumarraven147@gmail.com", "family" => null, "company" => "developer@dailyhappen.com"],
                "address" => ["current" => "VPO Barwa, Hisar, Haryana, India", "permanent" => "VPO Barwa, Hisar, Haryana, India"],
                "salary" => 0,
                "password" => OPENSSL::encode(config("mantis.app_id")),
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
