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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('aarti_slot_id')->constrained()->cascadeOnDelete();
            $table->string('seating_type')->default('general');
            $table->integer('devotee_count')->default(1);
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('address_city')->nullable();
            $table->decimal('ticket_amount', 10, 2)->default(0);
            $table->decimal('add_ons_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_status')->default('paid');
            $table->string('payment_method')->default('free_pass');
            $table->string('payment_id')->nullable();
            $table->string('booking_status')->default('confirmed');
            $table->string('qr_token')->unique();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['booking_number', 'booking_status']);
            $table->index(['contact_phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
