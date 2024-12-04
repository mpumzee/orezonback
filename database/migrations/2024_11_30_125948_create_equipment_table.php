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
    Schema::create('equipment', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('brand')->nullable();
        $table->string('description')->nullable();
        $table->string('category')->nullable();
        $table->decimal('prize', 8, 2)->nullable();
        $table->string('created_by')->nullable();
        $table->string('photo_url')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
