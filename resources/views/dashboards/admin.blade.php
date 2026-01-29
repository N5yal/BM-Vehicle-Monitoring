@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<div class="dashboard-page">
    <div class="dashboard-header">
        <div class="dashboard-title">
            <img src="{{ asset('images/splogoo.png') }}" alt="Logo">
            <h1>Admin Dashboard</h1>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="dashboard-body">

        {{-- Sidebar --}}
        <nav class="dashboard-nav">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('vehicles.index') }}">Vehicles</a>
            <a href="{{ route('fuel-slips.index') }}">Fuel Slips</a>
            <a href="{{ route('maintenances.index') }}">Maintenances</a>
        </nav>

        {{-- Main Content --}}
        <div class="dashboard-container">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                <h2 style="margin-top: 0;">Boardmembers Overview</h2>
            </div>

            <form method="GET" action="{{ route('admin.dashboard') }}" style="margin: 10px 0 18px; display:flex; align-items:center; gap:10px; justify-content:flex-end;">
                <label for="month" style="font-weight: 600; color:#1976d2;">Month:</label>
                <select id="month" name="month" onchange="this.form.submit()">
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <span style="font-size: 12px; color:#607d8b;">{{ $selectedMonthName }} {{ $year }}</span>
            </form>

            @if(empty($rows) || $rows->count() === 0)
                <p class="empty-message">No boardmembers found.</p>
            @else
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Boardmember</th>
                                <th>Plate #</th>
                                <th>Yearly Budget</th>
                                <th>Total Used (YTD)</th>
                                <th>Remaining Budget</th>
                                <th>Budget Used</th>
                                <th>Monthly Limit</th>
                                <th>Liters Used ({{ $selectedMonthName }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                @php
                                    $warnBudget = $row['yearlyBudget'] > 0 && $row['budgetUsedPercentage'] >= 80;
                                    $overBudget = $row['yearlyBudget'] > 0 && $row['remainingBudget'] < 0;
                                    $overMonthly = $row['monthlyLimit'] > 0 && $row['monthlyLitersUsed'] > $row['monthlyLimit'];
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div style="font-weight: 600;">{{ $row['user']->name }}</div>
                                        <div style="font-size: 12px; color:#607d8b;">{{ $row['user']->email }}</div>
                                    </td>
                                    <td>{{ $row['vehicle']?->plate_number ?? '—' }}</td>
                                    <td>₱{{ number_format((float) $row['yearlyBudget'], 2) }}</td>
                                    <td>₱{{ number_format((float) $row['totalUsed'], 2) }}</td>
                                    <td style="{{ $overBudget ? 'color:#d32f2f; font-weight:700;' : ($warnBudget ? 'color:#ff6f00; font-weight:700;' : '') }}">
                                        ₱{{ number_format((float) $row['remainingBudget'], 2) }}
                                    </td>
                                    <td style="{{ $warnBudget ? 'color:#ff6f00; font-weight:700;' : '' }}">
                                        {{ number_format((float) $row['budgetUsedPercentage'], 2) }}%
                                    </td>
                                    <td>{{ $row['monthlyLimit'] > 0 ? number_format((float) $row['monthlyLimit'], 2) . ' L' : '—' }}</td>
                                    <td style="{{ $overMonthly ? 'color:#d32f2f; font-weight:700;' : '' }}">
                                        {{ number_format((float) $row['monthlyLitersUsed'], 2) }} L
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div> {{-- dashboard-container --}}
    </div> {{-- dashboard-body --}}
</div> {{-- dashboard-page --}}
@endsection
