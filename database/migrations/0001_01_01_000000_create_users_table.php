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
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('city');
            $table->text('address');
            $table->string('phone')->unique();
            $table->string('shop_name')->nullable();
            $table->string('zip_code')->nullable();
            $table->enum('role', ['Admin', 'User'])->default('User');
            $table->enum('status' , ['active', 'inactive'])->default('inactive');
            $table->timestamps();
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
