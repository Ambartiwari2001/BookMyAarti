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
        Schema::create('aarti_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aarti_id')->constrained()->cascadeOnDelete();
            $table->date('slot_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('reporting_time')->nullable();
            $table->integer('total_capacity')->default(100);
            $table->integer('booked_seats')->default(0);
            $table->decimal('general_price', 10, 2)->default(0);
            $table->decimal('vip_price', 10, 2)->default(251.00);
            $table->string('status')->default('active');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index(['slot_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aarti_slots');
    }
};
