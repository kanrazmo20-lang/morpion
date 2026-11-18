<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partie_id')->constrained('parties')->cascadeOnDelete();
            $table->integer('position');
            $table->string('symbole', 1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coups');
    }
};