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
        Schema::create('location_connections', function (Blueprint $table) {
            $table->id();
            $table->string('from_location_code', 8); // 拠点Aのコード
            $table->string('to_location_code', 8); // 拠点Bのコード
            $table->timestamps();

            // 外部キー制約 (コードを使う)
            $table->foreign('from_location_code')->references('code')->on('locations')->onDelete('cascade');
            $table->foreign('to_location_code')->references('code')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_connections');
    }
};
