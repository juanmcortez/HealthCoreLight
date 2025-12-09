<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

use App\Enums\EmailType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            //
            $table->enum('email_type', EmailType::cases())->default(EmailType::PRIMARY->value);
            $table->string('email', 128)->unique();
            //
            $table->boolean('is_primary')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            //
            $table->foreignId('demographic_id')
                ->nullable()
                ->constrained('demographics')
                ->cascadeOnUpdate()
                ->onDelete('set null');
            //
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
