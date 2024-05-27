<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->default(2);

            $table->string('name', 100);
            $table->string('username')->unique();
            $table->string('nim')->unique();

            $table->string('date_of_birth', 50);
            $table->string('address', 100);
            $table->string('rt_number', 100);
            $table->string('rw_number', 100);
            $table->string('village', 100);
            $table->string('district', 100);
            $table->string('city', 100);
            $table->string('province', 100);
            $table->string('map_url', 100);

            $table->string('phone_number', 100);
            $table->text('hobby');


            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->constrained()->onDelete('cascade');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
