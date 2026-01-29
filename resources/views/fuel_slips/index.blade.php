@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@if(auth()->user()->role === 'admin')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endif

@if(auth()->user()->role === 'admin')
    <div class="dashboard-page">
        {{-- Header --}}
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

                {{-- Stats Cards --}}
                <div class="dashboard-sections">
                    <div class="dashboard-card">
                        <h3>Total Fuel Slips</h3>
                        <p>{{ $fuelSlips->count() }}</p>
                    </div>
                    <div class="dashboard-card">
                        <h3>Total Liters</h3>
                        <p>{{ $fuelSlips->sum('liters') }} L</p>
                    </div>
                    <div class="dashboard-card">
                        <h3>Total Cost</h3>
                        <p>₱{{ number_format($fuelSlips->sum('cost'), 2) }}</p>
                    </div>
                </div>

                <h2 style="margin-top: 20px;">Fuel Slips</h2>

@else
    <div class="dashboard-page">
        {{-- Header --}}
        <div class="dashboard-header">
            <div class="dashboard-title">
                <img src="{{ asset('images/splogoo.png') }}" alt="Logo">
                <h1>Sangguniang Panlalawigan</h1>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="dashboard-body">

            {{-- Sidebar --}}
            <nav class="dashboard-nav">
                <a href="{{ route('boardmember.dashboard') }}">Dashboard</a>
                <a href="{{ route('fuel-slips.index') }}">Fuel Slips</a>
                <a href="{{ route('maintenances.index') }}">Maintenances</a>
            </nav>

            {{-- Main Content --}}
            <div class="dashboard-container">
                <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                    <h2>Fuel Slips</h2>
                    <div class="top-actions">
                        <a href="{{ route('fuel-slips.create') }}" class="btn-primary btn-sm">+ Add Fuel Slip</a>
                    </div>
                </div>
@endif

                {{-- Success/Error Messages --}}
                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Fuel Slips Table --}}
                @if($fuelSlips->count() > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Vehicle</th>
                                    <th>Plate #</th>
                                    <th>Liters</th>
                                    <th>Cost</th>
                                    <th>KM</th>
                                    <th>Driver</th>
                                    <th>Control #</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fuelSlips as $slip)
                                    <tr>
                                        <td>{{ $slip->vehicle_name }}</td>
                                        <td>{{ $slip->plate_number }}</td>
                                        <td>{{ $slip->liters }}</td>
                                        <td>₱{{ number_format($slip->cost, 2) }}</td>
                                        <td>{{ $slip->km_reading }}</td>
                                        <td>{{ $slip->driver }}</td>
                                        <td>{{ $slip->control_number }}</td>
                                        <td>{{ $slip->date }}</td>
                                        <td>
                                            <a href="{{ route('fuel-slips.exportPDF', $slip->id) }}" class="btn-edit">PDF</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="empty-message">No fuel slips found.</p>
                @endif
            </div> {{-- dashboard-container --}}
        </div> {{-- dashboard-body --}}
    </div> {{-- dashboard-page --}}
@endsection
