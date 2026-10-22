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
        Schema::create('ghats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('city');
            $table->string('state');
            $table->string('river')->default('Ganga');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('image_url')->nullable();
            $table->text('reporting_instructions')->nullable();
            $table->text('guidelines')->nullable();
            $table->string('contact_helpline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ghats');
    }
};
