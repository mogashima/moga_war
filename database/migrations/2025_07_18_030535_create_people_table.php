<?php

use App\Types\JobType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id(); // id (bigint, primary)
            $table->string('name');
            $table->string('code', 8)->unique(); // 同じく長さ明示
            $table->string('location_code', 8)->nullable();
            $table->integer('lv');
            $table->integer('exp')->default(0);
            $table->string('job')->default(JobType::None);
            $table->integer('rank')->default(3);
            $table->integer('hp');
            $table->integer('mp');
            $table->integer('strength');
            $table->integer('intelligence');
            $table->integer('defense');
            $table->integer('resist');
            $table->integer('agility');
            $table->timestamps(); // created_at / updated_at

            $table->foreign('location_code')
                ->references('code')
                ->on('locations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
