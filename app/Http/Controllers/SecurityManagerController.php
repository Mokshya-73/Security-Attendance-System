<?php


namespace App\Http\Controllers;

use App\Models\SecurityManager;
use App\Models\PatrolOfficer\Timecard;
use App\Models\admin\ShiftType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SecurityManagerController extends Controller
{
    /**
     * Show dashboard with timecards of patrol officers under the manager
     */
    public function index(Request $request)
    {
        $manager = SecurityManager::where('user_core_data_id', Auth::id())->firstOrFail();
        $patrolOfficerIds = $manager->patrols()->pluck('user_core_data_id');

        $timecards = Timecard::with(['securityOfficer', 'shiftType', 'officer'])
            ->whereIn('patrol_officer_id', $patrolOfficerIds);

        // Filter by patrol officer
        if ($request->filled('officer_id')) {
            $timecards->where('patrol_officer_id', $request->officer_id);
        }

        // Filter by date
        if ($request->filled('date')) {
            $timecards->whereDate('started_at', $request->date);
        }

        $timecards = $timecards->latest()->get();
        $shifts = ShiftType::all();
        $officers = $manager->patrols()->with('core')->get();

        return view('security_manager.dashboard', compact('timecards', 'shifts', 'officers'));
    }


    /**
     * Update a timecard
     */
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

        $start = Carbon::parse(Carbon::parse($timecard->started_at)->toDateString() . ' ' . $request->started_at);
        $end = Carbon::parse($request->ended_date . ' ' . $request->ended_time);

        $shift = ShiftType::find($request->shift_type_id);
        $actual = $start->floatDiffInHours($end);
        $expected = $shift->duration;

        $timecard->update([
            'shift_type_id' => $request->shift_type_id,
            'started_at' => $start,
            'ended_at' => $end,
            'remarks' => $request->remarks,
            'is_overtime' => $actual > $expected,
            'overtime_hours' => $actual > $expected ? $actual - $expected : 0,
            'is_pay' => $actual >= $expected,
        ]);

        return redirect()->back()->with('success', 'Timecard updated successfully.');
    }

    /**
     * Delete a timecard
     */
    public function destroy($id)
    {
        $timecard = Timecard::findOrFail($id);
        $timecard->delete();

        return redirect()->back()->with('success', 'Timecard deleted successfully.');
    }
}
