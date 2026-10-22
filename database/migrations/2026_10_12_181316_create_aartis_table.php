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
        Schema::create('aartis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ghat_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('aarti_type')->default('evening');
            $table->string('timing_summary')->nullable();
            $table->integer('duration_minutes')->default(60);
            $table->text('description')->nullable();
            $table->text('significance')->nullable();
            $table->text('ritual_steps')->nullable();
            $table->string('banner_image')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aartis');
    }
};
