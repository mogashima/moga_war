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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique(); // 同じく長さ明示
            $table->string('faction_code', 8)->nullable(); // ← 長さ合わせる
            $table->string('name');
            $table->integer('pos_x');
            $table->integer('pos_y');
            $table->timestamps();

            $table->foreign('faction_code')
                ->references('code')
                ->on('factions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
