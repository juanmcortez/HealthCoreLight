<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the default columns.
            $table->dropColumn(['name', 'email', 'email_verified_at']);

            // Create the new ones.
            $table->string('username', 64)->unique()->index()->after('uid');
            $table->boolean('is_active')->default(true)->after('password');
            $table->boolean('profile_completed')->default(false)->after('is_active');
            $table->timestamp('last_login_at')->nullable()->after('profile_completed');

            // Add soft deletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop soft deletes
            $table->dropSoftDeletes();

            // Remove the new ones.
            $table->dropColumn(['username', 'is_active', 'profile_completed', 'last_login_at']);

            // Restore the default ones.
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
