@extends('layouts.app')

@section('title', ' - Services')

@section('content')
    <h1 class="mb-4">Available Services</h1>
    <div class="row">
        @forelse($services as $service)
            <div class="mb-4 col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text">{{ $service->description }}</p>
                        <p class="card-text"><strong>Price:</strong> EGP {{ number_format($service->price, 2) }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ $service->is_available ? 'Available' : 'Unavailable' }}</p>
                        @auth
                            @if($service->is_available)
                                <a href="{{ route('reservations.create', $service->id) }}" class="btn btn-primary">Reserve Now</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login to Reserve</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p>No services available.</p>
        @endforelse
    </div>
@endsection
