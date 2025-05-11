<!DOCTYPE html>
<html>
<head>
    <title>Reservation Cancelled</title>
</head>
<body>
    <h1>Reservation Cancelled</h1>
    <p>Dear {{ $reservation->user->name }},</p>
    <p>Your reservation for <strong>{{ $reservation->service->name }}</strong> has been cancelled.</p>
    <p><strong>Date & Time:</strong> {{ $reservation->reservation_date->format('Y-m-d H:i') }}</p>
    <p>We hope to serve you again soon!</p>
</body>
</html>
