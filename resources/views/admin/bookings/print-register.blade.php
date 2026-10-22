<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daily Devotee Sankalp Register - {{ $date }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 13px;
            color: #111;
            margin: 20px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #8b0000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #8b0000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 13px;
            color: #444;
        }
        .meta-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 12px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #777;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f5ece2;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .badge {
            font-size: 10px;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 4px;
            border: 1px solid #888;
        }
        .no-print {
            margin-bottom: 20px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 6px;
            display: flex;
            gap: 10px;
        }
        @media print {
            .no-print { display: none; }
            body { margin: 10px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" style="padding: 8px 16px; font-weight: bold; background: #8b0000; color: white; border: none; border-radius: 4px; cursor: pointer;">
            🖨 Print Sankalp Register
        </button>
        <button onclick="window.close()" style="padding: 8px 16px; font-weight: bold; background: #555; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Close
        </button>
    </div>

    <div class="header">
        <h1>॥ श्री गंगा सेवा निधि - दैनिक संकल्प एवं पुष्पार्पण पंजिका ॥</h1>
        <p>Official Devotee Sankalp & Pushpanjali Register for Head Vedic Priests</p>
    </div>

    <div class="meta-bar">
        <div>Date of Ritual: {{ Carbon\Carbon::parse($date)->format('l, d F Y') }}</div>
        <div>{{ $ghat ? 'Ghat: ' . $ghat->name . ' (' . $ghat->city . ')' : 'All Ghat Sanctuaries' }}</div>
        <div>Total Devotees Registered: {{ $bookings->sum('devotee_count') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">#</th>
                <th style="width: 90px;">Pass Ref</th>
                <th>Devotee Name(s)</th>
                <th style="width: 90px;">Gotra</th>
                <th>Sankalp Prayer / Seva Wish</th>
                <th style="width: 70px;">Seating</th>
                <th style="width: 130px;">Ceremony</th>
            </tr>
        </thead>
        <tbody>
            @php $row = 1; @endphp
            @forelse($bookings as $booking)
                @foreach($booking->devotees as $devotee)
                    <tr>
                        <td>{{ $row++ }}</td>
                        <td style="font-family: monospace; font-weight: bold;">{{ $booking->booking_number }}</td>
                        <td>
                            <strong>{{ $devotee->name }}</strong>
                            @if($devotee->age) <span style="font-size: 11px; color: #555;">({{ $devotee->age }} yrs)</span> @endif
                        </td>
                        <td style="font-weight: bold; color: #8b0000;">
                            {{ $devotee->gotra ?: 'Kashyap' }}
                        </td>
                        <td>
                            {{ $devotee->sankalp_purpose ?: 'Family Peace & Mother Ganga Blessings' }}
                        </td>
                        <td>
                            <span class="badge">{{ strtoupper($booking->seating_type) }}</span>
                        </td>
                        <td style="font-size: 11px;">
                            {{ $booking->slot->aarti->title }}
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No registered devotee sankalps found for this date.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; display: flex; justify-content: space-between; font-size: 12px;">
        <div>Pujari / Seva In-charge Signature: _______________________</div>
        <div>Verified by Gate Coordinator: _______________________</div>
    </div>

</body>
</html>
