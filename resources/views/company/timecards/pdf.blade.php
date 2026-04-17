<!DOCTYPE html>
<html>
<head>
    <title>Timecard Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Timecard Report</h2>
    <p><strong>Generated at:</strong> {{ now()->toDateTimeString() }}</p>

    <table>
        <thead>
            <tr>
                <th>Officer</th>
                <th>Start</th>
                <th>End</th>
                <th>Shift</th>
                <th>Worked</th>
                <th>Overtime</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timecards as $card)
            <tr>
                <td>{{ $card->securityOfficer->name ?? 'N/A' }}</td>
                <td>{{ $card->started_at }}</td>
                <td>{{ $card->ended_at }}</td>
                <td>{{ $card->shiftType->name ?? 'N/A' }}</td>
                <td>{{ $card->worked_hours }}</td>
                <td>{{ $card->overtime_hours }}</td>
                <td>{{ $card->remarks ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
