<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {

            $table->foreignId('uid')->constrained('users', 'uid')->cascadeOnDelete();
            $table->foreignId('rid')->constrained('roles')->cascadeOnDelete();
            // Combined primary key
            $table->primary(['uid', 'rid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
