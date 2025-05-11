{{-- <pre>{{ dd($services) }}</pre> --}}

<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="mb-4 row">
        <div class="col-md-4">
            <div class="text-white card bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Services</h5>
                    <p class="card-text">{{ $serviceStats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-white card bg-success">
                <div class="card-body">
                    <h5 class="card-title">Available Services</h5>
                    <p class="card-text">{{ $serviceStats['available'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-white card bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Reservations</h5>
                    <p class="card-text">{{ $reservationStats['total'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <div class="mb-4 card">
        <div class="card-header">
            <h5>Manage Services</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('services.create') }}" class="mb-3 btn btn-primary"><i class="fas fa-plus"></i> Add Service</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>EGP {{ number_format($service->price, 2) }}</td>
                            <td>{{ $service->is_available ? 'Available' : 'Unavailable' }}</td>
                            <td>
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">🔍 No services found. Try adding one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="card">
        <div class="card-header">
            <h5>Manage Reservations</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Service</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->service->name }}</td>
                            <td>{{ $reservation->reservation_date->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $reservation->status == 'pending' ? 'warning' : ($reservation->status == 'confirmed' ? 'success' : 'danger') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <button wire:click="confirmReservation({{ $reservation->id }})" class="btn btn-success btn-sm">Confirm</button>
                                @endif

                                @if($reservation->status !== 'cancelled')
                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <button wire:click="cancelReservation({{ $reservation->id }})" class="btn btn-danger btn-sm">Cancel</button>
                                @else
                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" id="delete-form-{{ $reservation->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $reservation->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete Permanently</button>
                                </form>


                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No reservations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
