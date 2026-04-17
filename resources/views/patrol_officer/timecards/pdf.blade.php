<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Attendance - {{ $carbonDate }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>🕒 Daily Attendance Report</h2>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($carbonDate)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Officer Name</th>
                <th>Service No</th>
                <th>Shift</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Overtime</th>
                <th>Pay</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($timecards as $index => $tc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tc->securityOfficer->name ?? '-' }}</td>
                <td>{{ $tc->securityOfficer->service_no ?? '-' }}</td>
                <td>{{ $tc->shiftType->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($tc->started_at)->format('h:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($tc->ended_at)->format('h:i A d-m-Y') }}</td>
                <td>
                    @if($tc->is_overtime)
                        +{{ number_format($tc->overtime_hours, 2) }} hrs
                    @else
                        -
                    @endif
                </td>
                <td>{{ $tc->is_pay ? '✅' : '❌' }}</td>
                <td>{{ $tc->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
