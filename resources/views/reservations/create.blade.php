@extends('layouts.app')

@section('title', ' - Reserve Service')

@section('content')
    <h1 class="mb-4">Reserve {{ $service->name }}</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <div class="mb-3">
                    <label for="reservation_date" class="form-label">Reservation Date & Time</label>
                    <input type="datetime-local" name="reservation_date" id="reservation_date" class="form-control" value="{{ old('reservation_date') }}" required>
                    @error('reservation_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Confirm Reservation</button>
            </form>
        </div>
    </div>
@endsection
