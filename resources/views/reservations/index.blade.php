@extends('layouts.app')

@section('title', ' - My Reservations')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">My Reservations</h1>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->service->name }}</td>
                                    <td>{{ $reservation->reservation_date->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->status == 'pending' ? 'warning' : ($reservation->status == 'confirmed' ? 'success' : 'danger') }}">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($reservation->status != 'cancelled')
                                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this reservation?')"><i class="fas fa-circle-xmark"></i> Cancel</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No reservations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
