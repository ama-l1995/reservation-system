<!DOCTYPE html>
<html>
<head>
    <title>Reservation Confirmed</title>
</head>
<body>
    <h1>Reservation Confirmed</h1>
    <p>Dear {{ $reservation->user->name }},</p>
    <p>Your reservation for <strong>{{ $reservation->service->name }}</strong> has been confirmed.</p>
    <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}
    </p>
    <p>Thank you for choosing our services!</p>
</body>
</html>
