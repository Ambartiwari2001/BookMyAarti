<?php

use App\Models\Aarti;
use App\Models\AartiSlot;
use App\Models\Booking;
use App\Models\Ghat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('home page loads successfully with spiritual branding', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('BookMyAarti');
    $response->assertSee('Ganga Aarti');
});

test('aartis listing page displays ceremonies and filters', function () {
    $response = $this->get('/aartis');

    $response->assertStatus(200);
    $response->assertSee('Sacred Aarti Ceremonies');
});

test('devotee can book a slot and seat capacity is atomically decremented', function () {
    $ghat = Ghat::first();
    $aarti = Aarti::where('ghat_id', $ghat->id)->first();
    $slot = AartiSlot::where('aarti_id', $aarti->id)
        ->where('status', 'active')
        ->first();

    $initialSeats = $slot->booked_seats;

    $bookingPayload = [
        'aarti_slot_id' => $slot->id,
        'seating_type' => 'vip',
        'devotee_count' => 2,
        'contact_name' => 'Meera Patel',
        'contact_email' => 'meera@example.com',
        'contact_phone' => '+91 9988776655',
        'address_city' => 'Ahmedabad',
        'devotees' => [
            [
                'name' => 'Meera Patel',
                'age' => 29,
                'gender' => 'female',
                'gotra' => 'Kashyap',
                'sankalp_purpose' => 'Family Well-being',
            ],
            [
                'name' => 'Rajesh Patel',
                'age' => 32,
                'gender' => 'male',
                'gotra' => 'Kashyap',
                'sankalp_purpose' => 'Health & Success',
            ],
        ],
        'payment_method' => 'online_upi',
    ];

    $response = $this->post('/book', $bookingPayload);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $booking = Booking::where('contact_email', 'meera@example.com')->first();
    expect($booking)->not->toBeNull();
    expect($booking->devotee_count)->toBe(2);
    expect($booking->booking_status)->toBe('confirmed');

    $slot->refresh();
    expect($slot->booked_seats)->toBe($initialSeats + 2);
});

test('pass page renders verified digital ticket and QR hash', function () {
    $booking = Booking::first();

    $response = $this->get('/booking/pass/'.$booking->booking_number);

    $response->assertStatus(200);
    $response->assertSee($booking->booking_number);
    $response->assertSee($booking->contact_name);
});

test('non-admin user is denied access to admin control panel', function () {
    $devotee = User::where('role', 'devotee')->first() ?? User::factory()->create(['role' => 'devotee']);

    $response = $this->actingAs($devotee)->get('/admin');

    $response->assertStatus(403);
});

test('admin user can access dashboard and management tools', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Administrative Overview');
});

test('admin can verify gate check-in for confirmed pass', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    $booking = Booking::where('booking_status', 'confirmed')->first();

    $response = $this->actingAs($admin)->post('/admin/check-in/'.$booking->id);

    $response->assertRedirect();
    $booking->refresh();
    expect($booking->booking_status)->toBe('checked_in');
    expect($booking->checked_in_at)->not->toBeNull();
});
