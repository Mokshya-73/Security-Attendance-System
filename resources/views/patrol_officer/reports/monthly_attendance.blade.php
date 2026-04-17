<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Attendance Report - {{ $monthLabel }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 15px;
            background: #ffffff;
            color: #333;
        }
        
        .report-container {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        
        .header h3 {
            font-size: 16px;
            margin: 0 0 5px 0;
            font-weight: bold;
        }
        
        .header h4 {
            font-size: 14px;
            margin: 0;
            font-weight: normal;
        }
        
        .meta-section {
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .meta-table td {
            padding: 5px 10px;
            border: none;
            font-size: 11px;
            vertical-align: top;
        }
        
        .meta-table td:not(:last-child) {
            border-right: 1px solid #ccc;
        }
        
        .meta-label {
            font-weight: bold;
            color: #555;
        }
        
        .signature-line {
            display: inline-block;
            border-bottom: 1px solid #333;
            min-width: 150px;
            margin-left: 5px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #333;
            margin-top: 10px;
        }
        
        .data-table th {
            background: #f0f0f0;
            border: 1px solid #333;
            padding: 8px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }
        
        .data-table td {
            border: 1px solid #333;
            padding: 6px 4px;
            text-align: center;
            font-size: 10px;
            vertical-align: middle;
        }
        
        .data-table tbody tr:nth-child(even) {
            background: #f8f8f8;
        }
        
        .col-no { width: 4%; }
        .col-title { width: 8%; }
        .col-name { width: 18%; text-align: left; }
        .col-shift { width: 10%; }
        .col-date { width: 12%; }
        .col-time { width: 12%; }
        .col-remarks { width: 12%; text-align: left; }
        
        .number-cell {
            font-weight: bold;
            background: #e8e8e8;
        }
        
        .name-cell {
            font-weight: 600;
            text-align: left;
            padding-left: 8px;
        }
        
        .date-cell {
            font-family: monospace;
            font-size: 9px;
        }
        
        .time-cell {
            font-family: monospace;
            font-size: 9px;
            font-weight: bold;
        }
        
        .remarks-cell {
            text-align: left;
            padding-left: 8px;
            font-style: italic;
        }
        
        @media print {
            body {
                padding: 0;
                font-size: 10px;
            }
            
            .data-table th,
            .data-table td {
                padding: 4px 2px;
                font-size: 9px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="header">
<p style="font-family: 'noto_sinhala'; font-size: 16px;">
   Monthly detailed report of security officers
</p>


            <h4>Full Report</h4>
        </div>

        <div class="meta-section">
            <table class="meta-table">
                <tr>
                    <td><span class="meta-label">Year:</span> {{ \Carbon\Carbon::parse($monthLabel)->format('Y') }}</td>
                    <td><span class="meta-label">Month:</span> {{ $monthLabel }}</td>
                    <td><span class="meta-label">Telecom Location:</span> <span class="signature-line"></span></td>
                    <td><span class="meta-label">Sign:</span> <span class="signature-line"></span></td>
                </tr>
            </table>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-title">Title</th>
                    <th class="col-name">Name</th>
                    <th class="col-shift">Shift</th>
                    <th class="col-date">Arrival Date</th>
                    <th class="col-time">Arrival Time</th>
                    <th class="col-date">Departure Date</th>
                    <th class="col-time">Departure Time</th>
                    <th class="col-remarks">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timecards as $index => $tc)
                    <tr>
                        <td class="number-cell">{{ $index + 1 }}</td>
                        <td>{{ $tc->securityOfficer->titleRelation->title ?? '-' }}</td>
                        <td class="name-cell">{{ $tc->securityOfficer->name }}</td>
                        <td>{{ $tc->shiftType->name ?? 'N/A' }}</td>
                        <td class="date-cell">{{ \Carbon\Carbon::parse($tc->started_at)->format('Y-m-d') }}</td>
                        <td class="time-cell">{{ \Carbon\Carbon::parse($tc->started_at)->format('h:i A') }}</td>
                        <td class="date-cell">{{ \Carbon\Carbon::parse($tc->ended_at)->format('Y-m-d') }}</td>
                        <td class="time-cell">{{ \Carbon\Carbon::parse($tc->ended_at)->format('h:i A') }}</td>
                        <td class="remarks-cell">{{ $tc->remarks ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>