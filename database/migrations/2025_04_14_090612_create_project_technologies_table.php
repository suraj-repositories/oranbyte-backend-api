<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_technology', function (Blueprint $table) {
            $table->foreignId('professional_experience_id')->constrained()->onDelete('cascade');
            $table->foreignId('technology_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['professional_experience_id', 'technology_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('experience_technology');
    }
};
