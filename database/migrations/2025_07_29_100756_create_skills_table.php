<?php

use App\Types\FormulaType;
use App\Types\SkillType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Types\TargetType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 8)->unique();
            $table->string('type')->default(SkillType::Physical);
            $table->string('target')->default(TargetType::Enemy);
            $table->integer('formula_type')->default(FormulaType::Normal);
            $table->integer('power')->default(0); // ダメージ威力
            $table->integer('cost')->default(0); // MPコスト
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
