<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\CompanyUser;
use App\Models\PatrolOfficer\Timecard;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Location;

class CompanyUserController extends Controller
{
    public function index()
{
    $companyUser = CompanyUser::where('user_core_data_id', Auth::id())->firstOrFail();

    $timecards = Timecard::with(['securityOfficer'])
        ->whereHas('securityOfficer', fn($q) => $q->where('company_id', $companyUser->company_id))
        ->get();

    $today = $timecards->where('started_at', '>=', \Carbon\Carbon::today())->count();
    $monthly = $timecards->where('started_at', '>=', \Carbon\Carbon::now()->startOfMonth())->count();
    $overtime = $timecards->sum('overtime_hours');
    $total = $timecards->count();

    return view('company.dashboard', compact('today', 'monthly', 'overtime', 'total'));
}


public function timecardsIndex(Request $request)
{
    $companyUser = CompanyUser::where('user_core_data_id', Auth::id())->firstOrFail();

    $query = Timecard::with([
        'securityOfficer.patrol.location',  // to show patrol leader & location
        'securityOfficer',
        'shiftType'
    ])->whereHas('securityOfficer', function ($q) use ($companyUser) {
        $q->where('company_id', $companyUser->company_id);
    });

    // Filter by location through patrol officer
    if ($request->filled('location_id')) {
        $query->whereHas('securityOfficer.patrol', function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        });
    }

    // Apply only one date filter
    if ($request->filled('date')) {
        $query->whereDate('started_at', $request->date);
    } elseif ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('started_at', [$request->start_date, $request->end_date]);
    } elseif ($request->filled('month')) {
        $month = Carbon::parse($request->month);
        $query->whereMonth('started_at', $month->month)
              ->whereYear('started_at', $month->year);
    }

    $timecards = $query->orderBy('started_at', 'desc')->get();

    $locations = Location::all(); // for filter dropdown

    return view('company.timecards.index', compact('timecards', 'locations'));
}


public function downloadPdf()
{
    $companyUser = CompanyUser::where('user_core_data_id', Auth::id())->firstOrFail();

    $timecards = Timecard::with(['securityOfficer', 'shiftType'])
        ->whereHas('securityOfficer', fn($q) => $q->where('company_id', $companyUser->company_id))
        ->orderBy('started_at', 'desc')
        ->get();

    $pdf = Pdf::loadView('company.timecards.pdf', compact('timecards'));
    return $pdf->download('timecard_report.pdf');
}

}
