<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('person_skill_codes', function (Blueprint $table) {
            $table->id();
            $table->string('person_code', 8);
            $table->string('skill_code', 8);
            $table->timestamps();

            $table->foreign('person_code')->references('code')->on('people');
            $table->foreign('skill_code')->references('code')->on('skills');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_skill_codes');
    }
};
