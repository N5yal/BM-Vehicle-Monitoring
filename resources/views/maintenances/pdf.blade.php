<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maintenance PDF</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body>
    <div style="text-align:center; margin-bottom:6px;">
        <img src="{{ public_path('images/splogoo.png') }}" alt="Logo" style="height: 64px;px; margin-bottom:4px;">
    </div>
    <h1>Maintenance Record</h1>

    <div class="meta">
        <div class="row"><span class="label">Call of No:</span> {{ $maintenance->call_of_no }}</div>
        <div class="row"><span class="label">Generated:</span> {{ now()->format('F d, Y h:i A') }}</div>
    </div>

    <div class="box">
        <table>
            <tr>
                <td class="key">Vehicle (Plate Number)</td>
                <td>{{ $maintenance->vehicle?->plate_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="key">Board Member</td>
                <td>{{ $maintenance->vehicle?->bm?->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="key">Maintenance Type</td>
                <td>{{ ucfirst($maintenance->maintenance_type ?? 'preventive') }}</td>
            </tr>
            <tr>
                <td class="key">Odometer KM</td>
                <td>{{ $maintenance->maintenance_km ?? '—' }}</td>
            </tr>
            <tr>
                <td class="key">Operation(s) Done</td>
                <td>{{ $maintenance->operation }}</td>
            </tr>
            <tr>
                <td class="key">Cost</td>
                <td>₱{{ number_format((float) $maintenance->cost, 2) }}</td>
            </tr>
            <tr>
                <td class="key">Conduct</td>
                <td>{{ $maintenance->conduct }}</td>
            </tr>
            <tr>
                <td class="key">Date</td>
                <td>{{ \Carbon\Carbon::parse($maintenance->date)->format('F d, Y') }}</td>
            </tr>
        </table>

        @if($maintenance->photo)
            @php
                // Read from storage/app/public to avoid relying on the public/storage symlink
                $photoPath = storage_path('app/public/' . $maintenance->photo);
                $photoDataUri = null;
                if (is_file($photoPath)) {
                    $mime = mime_content_type($photoPath) ?: 'image/jpeg';
                    $photoDataUri = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($photoPath));
                }
            @endphp

            @if($photoDataUri)
                <div class="photo">
                    <div class="label" style="margin-bottom: 6px;">Photo</div>
                    <img src="{{ $photoDataUri }}" alt="Maintenance photo">
                </div>
            @endif
        @endif
    </div>

    <div class="footer">
        This document is system-generated.
    </div>
</body>
</html>

