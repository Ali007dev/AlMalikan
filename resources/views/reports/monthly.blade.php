<!DOCTYPE html>
<html>
<head>
    <title>Monthly Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Monthly Report</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Branch Name</th>
                <th>Service Name</th>
                <th>Customer Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
            <tr>
                <td>{{ $booking->date }}</td>
                <td>{{ $booking->time }}</td>
                <td>{{ $booking->branchName }}</td>
                <td>{{ $booking->serviceName }}</td>
                <td>{{ $booking->customerFirstName }} {{ $booking->customerLastName }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
