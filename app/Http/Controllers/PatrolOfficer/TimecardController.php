<?php

namespace App\Http\Controllers\PatrolOfficer;

use App\Http\Controllers\Controller;
use App\Models\PatrolOfficer\Timecard;
use App\Models\admin\ShiftType;
use App\Models\SecurityOfficer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\PatrolOfficer;



class TimecardController extends Controller
{
    public function index(Request $request)
    {
        $patrol = PatrolOfficer::where('user_core_data_id', Auth::id())->first();
        $shifts = ShiftType::all();

        $filterDate = $request->get('filter_date', Carbon::today()->toDateString());

        $submittedOfficerIds = Timecard::whereDate('started_at', $filterDate)
            ->pluck('security_officer_id')
            ->toArray();

        $guards = SecurityOfficer::with(['title'])
            ->where('assigned_patrol_id', $patrol?->id)
            ->select('id', 'name', 'nic', 'title_id') // explicitly select nic and name
            ->whereNotIn('id', $submittedOfficerIds)
            ->get();


        $timecards = Timecard::where('patrol_officer_id', Auth::id())
            ->whereDate('started_at', $filterDate)
            ->latest()
            ->get();

        return view('patrol_officer.timecards.index', compact('guards', 'shifts', 'timecards'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'security_officer_id.*' => 'required|exists:security_officers,id',
            'shift_type_id.*' => 'required|exists:shift_types,id',
            'started_at.*' => 'required',
            'ended_date.*' => 'required|date',
            'ended_time.*' => 'required',
        ]);

        $count = count($request->security_officer_id);

        for ($i = 0; $i < $count; $i++) {
            $securityOfficerId = $request->security_officer_id[$i];
            $shiftTypeId = $request->shift_type_id[$i];
            $startTime = $request->started_at[$i];
            $endDate = $request->ended_date[$i];
            $endTime = $request->ended_time[$i];

            $start = Carbon::parse($request->date . ' ' . $startTime);
            $end = Carbon::parse($endDate . ' ' . $endTime);

            // ✅ Make sure both start and end are parsed correctly
            if (!$start || !$end || $end <= $start) {
                continue; // skip invalid rows
            }

            $exists = Timecard::whereDate('started_at', $start->toDateString())
                ->where('security_officer_id', $securityOfficerId)
                ->exists();

            if ($exists) {
                continue;
            }

            $shift = ShiftType::find($shiftTypeId);
            $actualHours = $start->floatDiffInHours($end);
            $expectedHours = $shift->duration;

            $isOvertime = $actualHours > $expectedHours;
            $overtimeHours = $isOvertime ? $actualHours - $expectedHours : 0;
            $isPay = $actualHours >= $expectedHours;
            $workedHours = $actualHours;

            Timecard::create([
                'patrol_officer_id' => Auth::id(),
                'security_officer_id' => $securityOfficerId,
                'shift_type_id' => $shiftTypeId,
                'started_at' => $start,
                'ended_at' => $end,
                'is_pay' => $isPay,
                'is_overtime' => $isOvertime,
                'overtime_hours' => $overtimeHours,
                'worked_hours' => $workedHours,
                'remarks' => $request->remarks[$i] ?? null,
            ]);
        }

        // Re-fetch data
        $patrol = PatrolOfficer::where('user_core_data_id', Auth::id())->first();
        $guards = SecurityOfficer::where('assigned_patrol_id', $patrol?->id)->get();
        $shifts = ShiftType::all();
        $filterDate = $request->date;

        $timecards = Timecard::where('patrol_officer_id', Auth::id())
            ->whereDate('started_at', $filterDate)
            ->latest()
            ->get();

        $submittedGuardsByDate = Timecard::selectRaw('security_officer_id, DATE(started_at) as date')
            ->get()
            ->groupBy('date')
            ->map(fn($items) => $items->pluck('security_officer_id')->toArray());

        return view('patrol_officer.timecards.index', compact('guards', 'shifts', 'timecards', 'submittedGuardsByDate'));
    }


    //Added by frontend
    public function monthlyAttendanceCounts(Request $request)
    {
        $year = $request->input('year', date('Y')); // Default to current year
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();

            $counts[] = Timecard::whereBetween('started_at', [$startDate, $endDate])
                ->count();
        }

        return response()->json([
            'counts' => $counts,
            'year' => $year
        ]);
    }


    // public function checkGuardsByDate($date)
    // {
    //     $guards = Timecard::whereDate('started_at', $date)
    //         ->pluck('security_officer_id');

    //     return response()->json($guards);
    // }
    public function checkGuardsByDate($date)
    {
        $dateStart = Carbon::parse($date)->startOfDay();
        $dateEnd = Carbon::parse($date)->endOfDay();

        $guards = Timecard::where(function ($query) use ($dateStart, $dateEnd) {
            $query->whereBetween('started_at', [$dateStart, $dateEnd])
                ->orWhereBetween('ended_at', [$dateStart, $dateEnd])
                ->orWhere(function ($q) use ($dateStart, $dateEnd) {
                    $q->where('started_at', '<', $dateStart)
                        ->where('ended_at', '>', $dateEnd);
                });
        })
            ->pluck('security_officer_id');

        return response()->json($guards);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shift_type_id' => 'required|exists:shift_types,id',
            'started_at' => 'required',
            'ended_date' => 'required|date',
            'ended_time' => 'required',
            'remarks' => 'nullable|string',
        ]);

        $timecard = Timecard::findOrFail($id);
        $shift = ShiftType::findOrFail($request->shift_type_id);

        $startDate = Carbon::parse($timecard->started_at)->toDateString();
        $start = Carbon::parse("$startDate {$request->started_at}");
        $end = Carbon::parse("{$request->ended_date} {$request->ended_time}");

        $actualHours = $start->floatDiffInHours($end);
        $expectedHours = $shift->duration;

        $isOvertime = $actualHours > $expectedHours;
        $overtimeHours = $isOvertime ? $actualHours - $expectedHours : 0;
        $isPay = $actualHours >= $expectedHours;
        $workedHours = $actualHours;

        $timecard->update([
            'shift_type_id' => $request->shift_type_id,
            'started_at' => $start,
            'ended_at' => $end,
            'remarks' => $request->remarks,
            'is_overtime' => $isOvertime,
            'overtime_hours' => $overtimeHours,
            'worked_hours' => $workedHours,
            'is_pay' => $isPay,
        ]);

        return response()->json(['message' => 'Timecard updated successfully.']);
    }


    public function generatePdf($date)
    {
        $carbonDate = \Carbon\Carbon::parse($date)->toDateString();

        $timecards = Timecard::whereDate('started_at', $carbonDate)
            ->with(['securityOfficer', 'shiftType'])
            ->orderBy('started_at')
            ->get();

        $pdf = Pdf::loadView('patrol_officer.timecards.pdf', compact('timecards', 'carbonDate'));
        return $pdf->download("Daily-Attendance-{$carbonDate}.pdf");
    }

    public function destroy($id)
    {
        $timecard = Timecard::findOrFail($id);
        $timecard->delete();

        return redirect()->back()->with('success', 'Timecard deleted successfully.');
    }
    public function download(Request $request)
    {
        // Validate month format
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $patrolOfficerId = Auth::id();
        $month = $request->month;

        // Define date range
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // Get timecards for current patrol officer's guards
        $timecards = Timecard::where('patrol_officer_id', $patrolOfficerId)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->with(['securityOfficer.titleRelation', 'shiftType'])
            ->orderBy('started_at')
            ->get();

        $pdf = Pdf::loadView('patrol_officer.reports.monthly_attendance', [
            'timecards' => $timecards,
            'monthLabel' => $startDate->format('F Y'),
        ]);

        return $pdf->stream('Monthly-Attendance-' . $startDate->format('Y-m') . '.pdf');
    }

    public function searchGuards(Request $request)
    {
        $term = $request->query('q');

        $guards = SecurityOfficer::where('name', 'like', "%{$term}%")
            ->orWhere('nic', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'name', 'nic']);

        return response()->json($guards);
    }
}
