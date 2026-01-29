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
                <h2 style="margin-top:0;">Vehicles</h2>
                <div class="top-actions">
                    <a href="{{ route('vehicles.create') }}" class="btn-primary btn-sm">+ Add Vehicle</a>
                </div>
            </div>

            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if($vehicles->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Board Member</th>
                                <th>Plate Number</th>
                                <th>Monthly Fuel Limit</th>
                                <th>Current KM</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $vehicle->bm->name ?? 'N/A' }}</td>
                                    <td>{{ $vehicle->plate_number }}</td>
                                    <td>{{ $vehicle->monthly_fuel_limit }} liters</td>
                                    <td>{{ $vehicle->current_km ?? 0 }} km</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn-edit">Edit</a>
                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this vehicle?')" class="btn-delete">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="empty-message">No vehicles found.</p>
            @endif
        </div> {{-- dashboard-container --}}
    </div> {{-- dashboard-body --}}
</div> {{-- dashboard-page --}}
@endsection
