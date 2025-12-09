<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

use App\Enums\Gender;
use App\Enums\Ethnicity;
use App\Enums\PreferredLanguage;
use App\Enums\IdentificationType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demographics', function (Blueprint $table) {
            $table->id();
            //
            $table->string('first_name', 128);
            $table->string('middle_name', 128)->nullable();
            $table->string('last_name', 128);
            //
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', Gender::cases())->nullable();
            //
            $table->string('identification_number', 24)->nullable();
            $table->enum('identification_type', IdentificationType::cases())->nullable();
            //
            $table->enum('ethnicity', Ethnicity::cases())->nullable();
            $table->enum('preferred_language', PreferredLanguage::cases())->default('en');
            //
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demographics');
    }
};
