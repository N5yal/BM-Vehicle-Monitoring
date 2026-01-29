@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@if(auth()->user()->role === 'admin')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">

<div class="dashboard-page">
    @if(auth()->user()->role === 'admin')
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
    @else
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
    @endif

    <div class="dashboard-body">
        <nav class="dashboard-nav">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('vehicles.index') }}">Vehicles</a>
                <a href="{{ route('fuel-slips.index') }}">Fuel Slips</a>
                <a href="{{ route('maintenances.index') }}">Maintenances</a>
            @else
                <a href="{{ route('boardmember.dashboard') }}">Dashboard</a>
                <a href="{{ route('fuel-slips.index') }}">Fuel Slips</a>
                <a href="{{ route('maintenances.index') }}">Maintenances</a>
            @endif
        </nav>

        <div class="dashboard-container">
            <div class="form-card">
        <h2>Edit Vehicle</h2>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="plate_number">Plate Number:</label>
            <input id="plate_number" type="text" name="plate_number" required value="{{ old('plate_number', $vehicle->plate_number) }}" placeholder="Enter plate number">

            <label for="monthly_fuel_limit">Monthly Fuel Limit (liters):</label>
            <input id="monthly_fuel_limit" type="number" name="monthly_fuel_limit" required value="{{ old('monthly_fuel_limit', $vehicle->monthly_fuel_limit) }}" min="1" step="0.01">

            <label for="current_km">Current KM:</label>
            <input id="current_km" type="number" name="current_km" value="{{ old('current_km', $vehicle->current_km ?? 0) }}" min="0">

            <button type="submit">Update Vehicle</button>
        </form>
            </div>
        </div> {{-- dashboard-container --}}
    </div> {{-- dashboard-body --}}
</div> {{-- dashboard-page --}}
@endsection
