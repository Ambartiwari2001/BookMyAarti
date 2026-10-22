<?php

namespace Database\Seeders;

use App\Models\Aarti;
use App\Models\AartiSlot;
use App\Models\AddOn;
use App\Models\Booking;
use App\Models\BookingAddOn;
use App\Models\DevoteeDetail;
use App\Models\Ghat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users (Admin and Devotee)
        $admin = User::updateOrCreate(
            ['email' => 'admin@bookmyaarti.com'],
            [
                'name' => 'Ghat Prabandhak (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+91 98765 43210',
            ]
        );

        $devoteeUser = User::updateOrCreate(
            ['email' => 'devotee@example.com'],
            [
                'name' => 'Aarav Sharma',
                'password' => Hash::make('password'),
                'role' => 'devotee',
                'phone' => '+91 91234 56789',
            ]
        );

        // 2. Ghats
        $dashashwamedh = Ghat::updateOrCreate(
            ['slug' => 'dashashwamedh-ghat-varanasi'],
            [
                'name' => 'Dashashwamedh Ghat',
                'city' => 'Varanasi',
                'state' => 'Uttar Pradesh',
                'river' => 'Ganga',
                'description' => 'The most iconic and spiritually charged ghat in Varanasi, renowned worldwide for the mesmerizing evening Maha Ganga Aarti performed by young priests in synchronized Vedic choreography with multi-tiered brass oil lamps.',
                'address' => 'Dashashwamedh Ghat Road, Bangali Tola, Varanasi, Uttar Pradesh 221001',
                'image_url' => 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=1200&q=80',
                'reporting_instructions' => 'Report at Entry Gate 3 (Near Ganga Seva Nidhi dais) at least 45 minutes prior to the Aarti. Show your digital E-Pass on mobile to the seva volunteer.',
                'guidelines' => 'Modest traditional dress recommended. Footwear must be deposited at the free shoe counter. Photography allowed from designated viewing tiers.',
                'contact_helpline' => '+91 542 2277123',
                'is_active' => true,
            ]
        );

        $harKiPauri = Ghat::updateOrCreate(
            ['slug' => 'har-ki-pauri-haridwar'],
            [
                'name' => 'Har Ki Pauri (Brahmakund)',
                'city' => 'Haridwar',
                'state' => 'Uttarakhand',
                'river' => 'Ganga',
                'description' => 'Literally meaning "Footsteps of the Lord", Har Ki Pauri is the sacred heart of Haridwar where drops of nectar (Amrit) fell during Samudra Manthan. The evening Aarti here illuminates the surging Himalayan current with thousands of floating deepams.',
                'address' => 'Har Ki Pauri, Kharkhari, Haridwar, Uttarakhand 249401',
                'image_url' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=80',
                'reporting_instructions' => 'Report at the Clock Tower Seva Kendra 40 minutes before twilight Aarti. Carry valid photo ID and digital ticket.',
                'guidelines' => 'Keep sacred items and prasad respectful. Plastic bags are strictly prohibited around Brahmakund.',
                'contact_helpline' => '+91 1334 226688',
                'is_active' => true,
            ]
        );

        $triveniGhat = Ghat::updateOrCreate(
            ['slug' => 'triveni-ghat-rishikesh'],
            [
                'name' => 'Triveni Ghat',
                'city' => 'Rishikesh',
                'state' => 'Uttarakhand',
                'river' => 'Ganga',
                'description' => 'The confluence of three sacred rivers (Ganga, Yamuna, and legendary Saraswati). Renowned for peaceful Maha Aarti where devotees chant the Maha Mantra in unison as temple bells echo against the Shivalik hills.',
                'address' => 'Mayakund, Rishikesh, Uttarakhand 249201',
                'image_url' => 'https://images.unsplash.com/photo-1600100397608-f010f4439c2c?auto=format&fit=crop&w=1200&q=80',
                'reporting_instructions' => 'Assembly at Triveni Sangam steps by 5:30 PM. Collect your sanctified floral diya from the Seva Counter.',
                'guidelines' => 'Maintain silence during Vedic shloka recitation. Devotees may release their floating diyas after the concluding arpan.',
                'contact_helpline' => '+91 135 2430044',
                'is_active' => true,
            ]
        );

        $assiGhat = Ghat::updateOrCreate(
            ['slug' => 'assi-ghat-varanasi'],
            [
                'name' => 'Assi Ghat',
                'city' => 'Varanasi',
                'state' => 'Uttar Pradesh',
                'river' => 'Ganga',
                'description' => 'The southernmost ghat of Kashi where the Assi river meets the holy Ganga. Famous for Subah-e-Banaras sunrise rituals, morning Surya Namaskar, classical shehnai recitals, and morning Aarti at dawn.',
                'address' => 'Assi Ghat, Shivala, Varanasi, Uttar Pradesh 221005',
                'image_url' => 'https://images.unsplash.com/photo-1571536802807-30451e3955d8?auto=format&fit=crop&w=1200&q=80',
                'reporting_instructions' => 'Please arrive 30 minutes before sunrise (around 05:00 AM) to experience the Vedic chanting and yagya.',
                'guidelines' => 'Morning peaceful atmosphere. Devotees are welcome to participate in morning meditation and yoga following the Aarti.',
                'contact_helpline' => '+91 542 2311890',
                'is_active' => true,
            ]
        );

        // 3. Aartis
        $mahaGangaAarti = Aarti::updateOrCreate(
            ['slug' => 'maha-ganga-aarti-varanasi'],
            [
                'ghat_id' => $dashashwamedh->id,
                'title' => 'Maha Ganga Aarti (Evening)',
                'aarti_type' => 'evening',
                'timing_summary' => '06:30 PM - 07:45 PM Daily',
                'duration_minutes' => 75,
                'description' => 'The world-famous ritual performed by 7 Vedic priests holding 4.5 kg multi-tiered brass deepams. Features rhythmic conch blowing, incense waves, peacock feather fans, and grand holy chants dedicated to Maa Ganga.',
                'significance' => 'Performing or witnessing the evening Ganga Aarti dispels negative karma and invokes the divine grace of Mother Ganga and Lord Vishwanath.',
                'ritual_steps' => "1. Shankhnaad & Dhwajarohan\n2. Dhoop & Chandan Arpan\n3. Maha Deepam Aarti (108 Wicks)\n4. Chamar & Morpankh Seva\n5. Ganga Stuti & Pushpanjali Arpan",
                'banner_image' => 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 0,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $subahBanaras = Aarti::updateOrCreate(
            ['slug' => 'subah-e-banaras-assi-ghat'],
            [
                'ghat_id' => $assiGhat->id,
                'title' => 'Subah-e-Banaras Morning Aarti',
                'aarti_type' => 'morning',
                'timing_summary' => '05:30 AM - 06:45 AM Daily',
                'duration_minutes' => 75,
                'description' => 'A soulful spiritual awakening ceremony marking dawn at the holy confluence of Ganga and Assi rivers, featuring sunrise yagya, Vedic chants by young scholars, and musical raga salutations to the Sun God.',
                'significance' => 'Brings peace of mind, health, and spiritual clarity as the first rays of the sun reflect upon the holy river.',
                'ritual_steps' => "1. Pratah Yagya & Havan\n2. Surya Vandana\n3. Ganga Mangal Aarti\n4. Classical Raga Dedication",
                'banner_image' => 'https://images.unsplash.com/photo-1571536802807-30451e3955d8?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 0,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $haridwarSandhya = Aarti::updateOrCreate(
            ['slug' => 'har-ki-pauri-sandhya-aarti'],
            [
                'ghat_id' => $harKiPauri->id,
                'title' => 'Brahmakund Sandhya Ganga Aarti',
                'aarti_type' => 'evening',
                'timing_summary' => '06:00 PM - 07:15 PM Daily',
                'duration_minutes' => 75,
                'description' => 'Grand evening invocation at the legendary spot where the celestial river meets the plains. Witness the golden reflection of sacred flames as hundreds of pandits chant Jai Gange Mata.',
                'significance' => 'A sacred bath and aarti darshan at Brahmakund is believed to cleanse centuries of worldly afflictions.',
                'ritual_steps' => "1. Ganga Sahasranama chanting\n2. Tilak & Sankalp ceremony\n3. Maha Deepam Aarti\n4. Deep Daan in the flowing river",
                'banner_image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 0,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $rishikeshAarti = Aarti::updateOrCreate(
            ['slug' => 'triveni-ghat-maha-aarti'],
            [
                'ghat_id' => $triveniGhat->id,
                'title' => 'Triveni Sangam Divine Aarti',
                'aarti_type' => 'evening',
                'timing_summary' => '06:15 PM - 07:30 PM Daily',
                'duration_minutes' => 75,
                'description' => 'Experience supreme tranquility in the Yoga Capital as priests chant ancient mantras and devotees sing devotional hymns under the twilight Himalayan sky.',
                'significance' => 'Invokes harmonious vibrations, inner peace, and blessing of the sacred river trinity.',
                'ritual_steps' => "1. Vedic Shanti Paath\n2. Dhoop & Agnihotra offering\n3. Synchronized Maha Deepam\n4. Community Kirtan",
                'banner_image' => 'https://images.unsplash.com/photo-1600100397608-f010f4439c2c?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 0,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 4. Add-ons
        $prasad = AddOn::updateOrCreate(
            ['slug' => 'special-archana-prasad-box'],
            [
                'name' => 'Special Archana Prasad Box',
                'price' => 151.00,
                'description' => 'Sanctified dry fruits, Kashi peda, holy sacred thread (mauli), and energized Rudraksha bead offered directly during the Aarti.',
                'icon' => 'gift',
                'is_active' => true,
            ]
        );

        $diya = AddOn::updateOrCreate(
            ['slug' => 'handcrafted-brass-floating-diya'],
            [
                'name' => 'Handcrafted Floating Diya & Flowers',
                'price' => 51.00,
                'description' => 'Eco-friendly leaf dona with sacred cow ghee diya, marigold flowers, and rose petals for personal deep-daan in Mother Ganga.',
                'icon' => 'sparkles',
                'is_active' => true,
            ]
        );

        $kalash = AddOn::updateOrCreate(
            ['slug' => 'ganga-jal-sealed-copper-kalash'],
            [
                'name' => 'Ganga Jal Sealed Copper Kalash',
                'price' => 101.00,
                'description' => 'Purified, lab-tested holy Gangajal sealed in a sacred copper kalash with temple seal for your home altar or puja room.',
                'icon' => 'drop',
                'is_active' => true,
            ]
        );

        $boatSeat = AddOn::updateOrCreate(
            ['slug' => 'reserved-wooden-boat-viewing-seat'],
            [
                'name' => 'Reserved Boat Aarti Viewing Seat',
                'price' => 351.00,
                'description' => 'Exclusive front-row river vantage point from a decorated traditional wooden heritage boat moored right in front of the Aarti dais.',
                'icon' => 'sun',
                'is_active' => true,
            ]
        );

        // 5. Generate Aarti Slots for next 14 days
        $allAartis = [$mahaGangaAarti, $subahBanaras, $haridwarSandhya, $rishikeshAarti];
        $today = Carbon::today();

        for ($i = 0; $i < 14; $i++) {
            $slotDate = $today->copy()->addDays($i);

            foreach ($allAartis as $aarti) {
                $isMorning = ($aarti->aarti_type === 'morning');
                $startTime = $isMorning ? '05:30:00' : '18:30:00';
                $endTime = $isMorning ? '06:45:00' : '19:45:00';
                $reportingTime = $isMorning ? '05:00 AM (30 mins prior)' : '05:45 PM (45 mins prior)';

                AartiSlot::firstOrCreate(
                    [
                        'aarti_id' => $aarti->id,
                        'slot_date' => $slotDate->toDateString(),
                        'start_time' => $startTime,
                    ],
                    [
                        'end_time' => $endTime,
                        'reporting_time' => $reportingTime,
                        'total_capacity' => 150,
                        'booked_seats' => ($i === 0 ? 42 : ($i === 1 ? 18 : 0)),
                        'general_price' => 0.00,
                        'vip_price' => 251.00,
                        'status' => 'active',
                        'notes' => 'Daily verified ritual pass',
                    ]
                );
            }
        }

        // 6. Create demo bookings for realistic dashboard metrics
        $firstSlot = AartiSlot::where('aarti_id', $mahaGangaAarti->id)
            ->whereDate('slot_date', $today->toDateString())
            ->first() ?? AartiSlot::first();

        if ($firstSlot) {
            $booking1 = Booking::updateOrCreate(
                ['booking_number' => 'BMA-2026-A101'],
                [
                    'user_id' => $devoteeUser->id,
                    'aarti_slot_id' => $firstSlot->id,
                    'seating_type' => 'vip',
                    'devotee_count' => 2,
                    'contact_name' => 'Aarav Sharma',
                    'contact_email' => 'devotee@example.com',
                    'contact_phone' => '+91 91234 56789',
                    'address_city' => 'Delhi',
                    'ticket_amount' => 502.00,
                    'add_ons_amount' => 202.00,
                    'total_amount' => 704.00,
                    'payment_status' => 'paid',
                    'payment_method' => 'online_upi',
                    'payment_id' => 'pay_UPI_9921448',
                    'booking_status' => 'confirmed',
                    'qr_token' => Str::random(32),
                    'notes' => 'VIP platform seating requested near priest dais.',
                ]
            );

            DevoteeDetail::updateOrCreate(
                ['booking_id' => $booking1->id, 'name' => 'Aarav Sharma'],
                [
                    'age' => 34,
                    'gender' => 'male',
                    'gotra' => 'Kashyap',
                    'sankalp_purpose' => 'Family Well-being & Peace',
                    'id_proof_type' => 'Aadhaar',
                    'id_proof_number' => 'XXXXXXXX4892',
                ]
            );

            DevoteeDetail::updateOrCreate(
                ['booking_id' => $booking1->id, 'name' => 'Pooja Sharma'],
                [
                    'age' => 31,
                    'gender' => 'female',
                    'gotra' => 'Kashyap',
                    'sankalp_purpose' => 'Health & Prosperity',
                    'id_proof_type' => 'Aadhaar',
                    'id_proof_number' => 'XXXXXXXX1124',
                ]
            );

            BookingAddOn::updateOrCreate(
                ['booking_id' => $booking1->id, 'add_on_id' => $prasad->id],
                [
                    'quantity' => 1,
                    'unit_price' => 151.00,
                    'subtotal' => 151.00,
                ]
            );

            BookingAddOn::updateOrCreate(
                ['booking_id' => $booking1->id, 'add_on_id' => $diya->id],
                [
                    'quantity' => 1,
                    'unit_price' => 51.00,
                    'subtotal' => 51.00,
                ]
            );

            // Free General Booking Demo
            $booking2 = Booking::updateOrCreate(
                ['booking_number' => 'BMA-2026-F202'],
                [
                    'user_id' => null,
                    'aarti_slot_id' => $firstSlot->id,
                    'seating_type' => 'general',
                    'devotee_count' => 1,
                    'contact_name' => 'Sunil Verma',
                    'contact_email' => 'sunil.verma@example.com',
                    'contact_phone' => '+91 98888 77777',
                    'address_city' => 'Lucknow',
                    'ticket_amount' => 0.00,
                    'add_ons_amount' => 51.00,
                    'total_amount' => 51.00,
                    'payment_status' => 'paid',
                    'payment_method' => 'free_pass',
                    'booking_status' => 'confirmed',
                    'qr_token' => Str::random(32),
                    'notes' => 'General darshan pass with floral diya offering',
                ]
            );

            DevoteeDetail::updateOrCreate(
                ['booking_id' => $booking2->id, 'name' => 'Sunil Verma'],
                [
                    'age' => 58,
                    'gender' => 'male',
                    'gotra' => 'Bharadwaj',
                    'sankalp_purpose' => 'Moksha & Spiritual Blessing',
                    'id_proof_type' => 'Voter ID',
                    'id_proof_number' => 'VTR99120',
                ]
            );

            BookingAddOn::updateOrCreate(
                ['booking_id' => $booking2->id, 'add_on_id' => $diya->id],
                [
                    'quantity' => 1,
                    'unit_price' => 51.00,
                    'subtotal' => 51.00,
                ]
            );
        }
    }
}
