@extends('layouts.app')

@section('title', ' - Edit Reservation')

@section('content')
    <h1 class="mb-4">Edit Reservation</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="reservation_date" class="form-label">New Date & Time:</label>
                    <input type="datetime-local" class="form-control" name="reservation_date" value="{{ $reservation->reservation_date->format('Y-m-d\TH:i') }}" required>
                </div>

                <button type="submit" class="mt-2 btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection


