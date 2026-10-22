@extends('layouts.app')

@section('title', 'Reserve Aarti Pass - ' . $slot->aarti->title)

@section('content')
<div class="bg-stone-900 text-white py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('aartis.show', $slot->aarti->slug) }}" class="inline-flex items-center gap-1.5 text-xs text-amber-400 hover:underline mb-3">
            &larr; Back to {{ $slot->aarti->title }}
        </a>
        <h1 class="font-cinzel text-2xl sm:text-4xl font-extrabold text-white">
            Devotee Aarti Pass Reservation
        </h1>
        <div class="flex flex-wrap items-center gap-3 mt-3 text-xs text-stone-300">
            <span class="px-2.5 py-1 rounded-lg bg-stone-800 border border-stone-700">📍 {{ $slot->aarti->ghat->name }}, {{ $slot->aarti->ghat->city }}</span>
            <span class="px-2.5 py-1 rounded-lg bg-stone-800 border border-stone-700">📅 {{ $slot->slot_date->format('D, d M Y') }}</span>
            <span class="px-2.5 py-1 rounded-lg bg-stone-800 border border-stone-700">⏰ {{ $slot->formatted_time }}</span>
            <span class="px-2.5 py-1 rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30 font-semibold">{{ $slot->available_seats }} Seats Remaining</span>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
        @csrf
        <input type="hidden" name="aarti_slot_id" value="{{ $slot->id }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Form Sections -->
            <div class="lg:col-span-2 space-y-8">

                <!-- 1. Seating Tier Selection -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">1</span>
                        <h2 class="text-base font-bold text-stone-900">Choose Seating Tier</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- General Free Tier -->
                        <label class="relative border-2 rounded-2xl p-5 cursor-pointer transition-all flex flex-col justify-between" id="tierLabelGeneral">
                            <input type="radio" name="seating_type" value="general" checked class="sr-only" onchange="updateCalculations()">
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-stone-900 text-sm">General Darshan</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">FREE</span>
                                </div>
                                <p class="text-xs text-stone-500">Tiered steps seating with open sacred river view. Gate reporting 45 mins prior.</p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-stone-100 text-xs font-bold text-stone-900">
                                ₹0 per person
                            </div>
                        </label>

                        <!-- VIP Platform Tier -->
                        <label class="relative border-2 rounded-2xl p-5 cursor-pointer transition-all flex flex-col justify-between" id="tierLabelVip">
                            <input type="radio" name="seating_type" value="vip" class="sr-only" onchange="updateCalculations()">
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-stone-900 text-sm">VIP Dais Platform</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">RESERVED</span>
                                </div>
                                <p class="text-xs text-stone-500">Front-row cushioned dais seating right opposite the Vedic priests' Aarti mandap.</p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-stone-100 text-xs font-bold text-orange-600">
                                ₹{{ number_format($slot->vip_price, 0) }} per person
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 2. Primary Devotee Contact -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">2</span>
                        <h2 class="text-base font-bold text-stone-900">Primary Contact Details</h2>
                    </div>
                    <p class="text-xs text-stone-500 mb-6">Your digital E-Pass & Gate verification code will be sent to this email & phone.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Full Name *</label>
                            <input type="text" name="contact_name" required value="{{ old('contact_name', auth()->user()->name ?? '') }}" 
                                   placeholder="e.g. Aarav Sharma" 
                                   class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Mobile Number (WhatsApp) *</label>
                            <input type="text" name="contact_phone" required value="{{ old('contact_phone', auth()->user()->phone ?? '') }}" 
                                   placeholder="+91 98765 43210" 
                                   class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Email Address *</label>
                            <input type="email" name="contact_email" required value="{{ old('contact_email', auth()->user()->email ?? '') }}" 
                                   placeholder="devotee@example.com" 
                                   class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">City / Hometown</label>
                            <input type="text" name="address_city" value="{{ old('address_city') }}" 
                                   placeholder="e.g. New Delhi, Mumbai, Lucknow" 
                                   class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                        </div>
                    </div>
                </div>

                <!-- 3. Devotee Sankalp & Attendees -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">3</span>
                            <h2 class="text-base font-bold text-stone-900">Devotees & Sankalp Prayers</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-stone-500">Attendees:</span>
                            <select name="devotee_count" id="devoteeCountSelect" onchange="adjustDevoteeRows()" 
                                    class="bg-stone-100 border border-stone-300 rounded-lg px-2.5 py-1 text-xs font-bold text-stone-800">
                                @for($i = 1; $i <= min(8, $slot->available_seats); $i++)
                                    <option value="{{ $i }}">{{ $i }} Devotee{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <p class="text-xs text-stone-500 mb-6">Enter family names and Gotra. Priests will recite these during the sacred Pushpanjali & Sankalp.</p>

                    <div id="devoteeRowsContainer" class="space-y-4">
                        <!-- Devotee 1 Row -->
                        <div class="devotee-row p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                            <div class="text-xs font-bold text-orange-600">Devotee #1 (Primary)</div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] font-medium text-stone-600 mb-1">Full Name *</label>
                                    <input type="text" name="devotees[0][name]" required placeholder="Devotee name" 
                                           class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-medium text-stone-600 mb-1">Age</label>
                                    <input type="number" name="devotees[0][age]" min="1" max="120" placeholder="e.g. 35" 
                                           class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-medium text-stone-600 mb-1">Gender</label>
                                    <select name="devotees[0][gender]" class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                <div>
                                    <label class="block text-[11px] font-medium text-stone-600 mb-1">Family Gotra (Optional)</label>
                                    <input type="text" name="devotees[0][gotra]" placeholder="e.g. Kashyap, Bharadwaj, Vashishta" 
                                           class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-medium text-stone-600 mb-1">Sankalp Prayer Wish (Optional)</label>
                                    <input type="text" name="devotees[0][sankalp_purpose]" placeholder="e.g. Family Health, Birthday Blessing, Peace" 
                                           class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Sacred Offerings & Add-Ons -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">4</span>
                        <h2 class="text-base font-bold text-stone-900">Sanctified Offerings & Prasad (Optional)</h2>
                    </div>
                    <p class="text-xs text-stone-500 mb-6">Handcrafted holy offerings prepared by the temple trust, handed to you upon arrival at the gate.</p>

                    <div class="space-y-3">
                        @foreach($addOns as $addon)
                            <div class="flex items-center justify-between p-4 rounded-2xl border border-stone-200 hover:border-amber-400 bg-stone-50/50 transition-colors">
                                <div class="max-w-md">
                                    <div class="flex items-center gap-2">
                                        <span class="text-amber-500">🪔</span>
                                        <span class="text-xs font-bold text-stone-900">{{ $addon->name }}</span>
                                        <span class="text-xs font-bold text-orange-600">₹{{ number_format($addon->price, 0) }}</span>
                                    </div>
                                    <p class="text-[11px] text-stone-500 mt-1 leading-relaxed">{{ $addon->description }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <label class="text-[11px] text-stone-500">Qty:</label>
                                    <select name="addons[{{ $addon->id }}]" data-price="{{ $addon->price }}" onchange="updateCalculations()" 
                                            class="addon-qty-select bg-white border border-stone-300 rounded-lg px-2.5 py-1 text-xs font-bold text-stone-800">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 5. Payment Selection -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">5</span>
                        <h2 class="text-base font-bold text-stone-900">Payment & Confirmation</h2>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-stone-200 bg-stone-50 cursor-pointer">
                            <input type="radio" name="payment_method" value="online_upi" checked class="text-orange-600 focus:ring-orange-500">
                            <div>
                                <span class="text-xs font-bold text-stone-900 block">Instant Online / UPI Simulation</span>
                                <span class="text-[11px] text-stone-500">Immediate E-Pass generation with instant confirmation.</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-stone-200 bg-stone-50 cursor-pointer">
                            <input type="radio" name="payment_method" value="free_pass" class="text-orange-600 focus:ring-orange-500">
                            <div>
                                <span class="text-xs font-bold text-stone-900 block">General Darshan Pass (Complimentary Seva)</span>
                                <span class="text-[11px] text-stone-500">Free admission for temple general stairs darshan.</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-medium text-stone-600 mb-1">Special Assistance Note (Optional)</label>
                        <textarea name="notes" rows="2" placeholder="e.g. Wheelchair assistance required for elderly, or anniversary sankalp" 
                                  class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden"></textarea>
                    </div>
                </div>
            </div>

            <!-- Right Col: Sticky Price Breakdown & Submit -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 bg-white rounded-3xl border border-stone-200 shadow-xl p-6 space-y-6">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-orange-600 block">Booking Summary</span>
                        <h3 class="font-cinzel text-lg font-bold text-stone-900 mt-1">{{ $slot->aarti->title }}</h3>
                        <p class="text-xs text-stone-500">{{ $slot->aarti->ghat->name }}</p>
                    </div>

                    <div class="bg-stone-50 rounded-2xl p-4 text-xs space-y-2 border border-stone-100">
                        <div class="flex justify-between">
                            <span class="text-stone-500">Date:</span>
                            <span class="font-bold text-stone-800">{{ $slot->slot_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Time:</span>
                            <span class="font-bold text-stone-800">{{ $slot->formatted_time }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Reporting:</span>
                            <span class="font-bold text-orange-600">{{ $slot->reporting_time ?? '45 mins prior' }}</span>
                        </div>
                    </div>

                    <!-- Price Calculations -->
                    <div class="space-y-3 pt-2 text-xs border-t border-stone-100">
                        <div class="flex justify-between">
                            <span class="text-stone-500" id="ticketLabelText">Tickets (1 Devotee):</span>
                            <span class="font-bold text-stone-800" id="ticketAmountDisplay">₹0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Sanctified Offerings:</span>
                            <span class="font-bold text-stone-800" id="addonsAmountDisplay">₹0</span>
                        </div>
                        <div class="pt-3 border-t border-stone-200 flex justify-between items-baseline">
                            <span class="text-sm font-bold text-stone-900">Total Payable:</span>
                            <span class="font-cinzel text-2xl font-extrabold text-orange-600" id="totalAmountDisplay">₹0</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-orange-600 via-amber-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold text-sm rounded-2xl shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                        <span>Confirm & Generate Pass</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>

                    <div class="text-[11px] text-stone-400 text-center flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span>Official Temple Trust Digital Pass</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const vipPricePerPerson = {{ $slot->vip_price }};
    const generalPricePerPerson = {{ $slot->general_price }};

    function updateCalculations() {
        const seatingType = document.querySelector('input[name="seating_type"]:checked').value;
        const count = parseInt(document.getElementById('devoteeCountSelect').value) || 1;

        // Styling radio cards
        const labelGen = document.getElementById('tierLabelGeneral');
        const labelVip = document.getElementById('tierLabelVip');

        if (seatingType === 'vip') {
            labelVip.classList.add('border-orange-500', 'bg-orange-50/40');
            labelVip.classList.remove('border-stone-200');
            labelGen.classList.remove('border-orange-500', 'bg-orange-50/40');
            labelGen.classList.add('border-stone-200');
        } else {
            labelGen.classList.add('border-orange-500', 'bg-orange-50/40');
            labelGen.classList.remove('border-stone-200');
            labelVip.classList.remove('border-orange-500', 'bg-orange-50/40');
            labelVip.classList.add('border-stone-200');
        }

        const ticketPrice = (seatingType === 'vip') ? (vipPricePerPerson * count) : (generalPricePerPerson * count);

        // Add-ons total
        let addonsTotal = 0;
        document.querySelectorAll('.addon-qty-select').forEach(select => {
            const qty = parseInt(select.value) || 0;
            const price = parseFloat(select.dataset.price) || 0;
            addonsTotal += (qty * price);
        });

        const total = ticketPrice + addonsTotal;

        document.getElementById('ticketLabelText').innerText = `Pass (${count} Devotee${count > 1 ? 's' : ''}):`;
        document.getElementById('ticketAmountDisplay').innerText = `₹${ticketPrice.toLocaleString('en-IN')}`;
        document.getElementById('addonsAmountDisplay').innerText = `₹${addonsTotal.toLocaleString('en-IN')}`;
        document.getElementById('totalAmountDisplay').innerText = `₹${total.toLocaleString('en-IN')}`;
    }

    function adjustDevoteeRows() {
        const count = parseInt(document.getElementById('devoteeCountSelect').value) || 1;
        const container = document.getElementById('devoteeRowsContainer');
        container.innerHTML = '';

        for (let i = 0; i < count; i++) {
            const row = document.createElement('div');
            row.className = 'devotee-row p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-3';
            row.innerHTML = `
                <div class="text-xs font-bold text-orange-600">Devotee #${i + 1} ${i === 0 ? '(Primary)' : ''}</div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-medium text-stone-600 mb-1">Full Name *</label>
                        <input type="text" name="devotees[${i}][name]" required placeholder="Devotee name" 
                               class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-stone-600 mb-1">Age</label>
                        <input type="number" name="devotees[${i}][age]" min="1" max="120" placeholder="e.g. 30" 
                               class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-stone-600 mb-1">Gender</label>
                        <select name="devotees[${i}][gender]" class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div>
                        <label class="block text-[11px] font-medium text-stone-600 mb-1">Family Gotra (Optional)</label>
                        <input type="text" name="devotees[${i}][gotra]" placeholder="e.g. Kashyap, Bharadwaj" 
                               class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-stone-600 mb-1">Sankalp Prayer Wish (Optional)</label>
                        <input type="text" name="devotees[${i}][sankalp_purpose]" placeholder="e.g. Health, Family Peace" 
                               class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2 text-xs text-stone-900">
                    </div>
                </div>
            `;
            container.appendChild(row);
        }

        updateCalculations();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        updateCalculations();
    });
</script>
@endsection
