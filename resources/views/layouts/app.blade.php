<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Reservation | {{ $title ?? '' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @livewireStyles
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
</head>
<body>
    <!-- Navbar -->
    <nav class="shadow-sm navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="gap-2 navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
                <span>Service Reservation</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="gap-2 navbar-nav align-items-center">
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('admin.dashboard') }}">
                                    Admin Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('services.index') ? 'active fw-semibold' : '' }}" href="{{ route('services.index') }}">
                                    Services
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reservations.index') ? 'active fw-semibold' : '' }}" href="{{ route('reservations.index') }}">
                                My Reservations
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="px-2 text-white nav-link btn btn-link fw-semibold">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active fw-semibold' : '' }}" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active fw-semibold' : '' }}" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        <div class="container py-4">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr Config -->
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "5000"
        };

        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if(session('error')) toastr.error("{{ session('error') }}"); @endif
        @if(session('toastr_type') && session('toastr_message'))
            toastr["{{ session('toastr_type') }}"]("{{ session('toastr_message') }}");
        @endif

        window.addEventListener('toastr:success', event => {
            toastr.success(event.detail);
        });

        window.addEventListener('toastr:error', event => {
            toastr.error(event.detail);
        });
    </script>

    <!-- SweetAlert -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function confirmPopup(id, type) {
            const actionText = type === 'confirm' ? 'confirm this reservation' : 'cancel this reservation';
            const method = type === 'confirm' ? 'confirmReservation' : 'cancelReservation';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${actionText}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: type === 'confirm' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.first().call(method, { id });
                }
            });
        }


    </script>

    @livewireScripts
</body>
</html>
