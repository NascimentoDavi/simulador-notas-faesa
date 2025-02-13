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
        Schema::create('LY_SIMULADOR_NOTA_FORMULAS', function (Blueprint $table) {
            $table->id(); // Automatically defined.
            $table->string('name');
            $table->string('created_by');
            $table->string('formula');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ly_simulador_nota_formulas');
    }
};
