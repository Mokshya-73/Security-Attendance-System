<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAccessLevel;
use App\Models\UserCoreData;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\ApproverDgm;
use App\Models\SecurityManager;
use App\Models\PatrolOfficer;
use App\Models\SecurityOfficer;
use App\Models\Location;

class UserManagementController extends Controller
{
    // Company Users
    public function indexCompanyUsers()
    {
        $companyUsers = CompanyUser::with(['company', 'core'])->get();
        return view('admin.company_users.index', compact('companyUsers'));
    }

    public function createCompanyUser()
    {
        $companies = Company::all();
        return view('admin.company_users.create', compact('companies'));
    }

    public function storeCompanyUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user_core_data,email',
            'password' => 'required|min:6',
            'company_id' => 'required|exists:companies,id'
        ]);

        $core = UserCoreData::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => UserAccessLevel::where('role', 'Company User')->value('id'),
            'status' => 'active',
        ]);

        CompanyUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'user_core_data_id' => $core->id,
        ]);

        return redirect()->route('admin.company_users.index')->with('success', 'Company User created');
    }

    public function editCompanyUser($id)
    {
        $companyUser = CompanyUser::with('core')->findOrFail($id);
        $companies = Company::all();
        return view('admin.company_users.edit', compact('companyUser', 'companies'));
    }

    public function updateCompanyUser(Request $request, $id)
    {
        $companyUser = CompanyUser::findOrFail($id);
        $core = $companyUser->core;

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user_core_data,email,' . $core->id,
            'company_id' => 'required|exists:companies,id'
        ]);

        $companyUser->update([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
        ]);

        $core->update([
            'email' => $request->email,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.company_users.index')->with('success', 'Company User updated');
    }

    public function deleteCompanyUser($id)
    {
        $companyUser = CompanyUser::findOrFail($id);
        $core = $companyUser->core;

        $companyUser->delete();
        $core->delete();

        return redirect()->route('admin.company_users.index')->with('success', 'Company User deleted');
    }

    // Approver
    public function indexApproverDgms()
    {
        $dgms = ApproverDgm::with('core')->get();
        return view('admin.approver.index', compact('dgms'));
    }

    public function createApproverDgm()
    {
        return view('admin.approver.create');
    }

    public function storeApproverDgm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'required|unique:user_core_data,employee_id',
            'password' => 'required|string|min:8|max:20',
        ], [
            'name.required' => 'The name field is required.',
            'employee_id.required' => 'The employee ID is required.',
            'employee_id.unique' => 'This employee ID is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not be greater than 20 characters.',
        ]);

        $core = UserCoreData::create([
            'employee_id' => $request->employee_id,
            'password' => bcrypt($request->password),
            'role_id' => UserAccessLevel::where('role', 'Approver DGM')->value('id'),
            'status' => 'active',
        ]);

        ApproverDgm::create([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'user_core_data_id' => $core->id,
        ]);

        return redirect()->route('admin.approver.index')->with('success', 'Approver DGM created successfully.');
    }

    public function editApproverDgm($id)
    {
        $dgm = ApproverDgm::with('core')->findOrFail($id);
        return view('admin.approver.edit', compact('dgm'));
    }

    public function updateApproverDgm(Request $request, $id)
    {
        $dgm = ApproverDgm::findOrFail($id);
        $core = $dgm->core;

        $request->validate([
            'name' => 'required',
            'employee_id' => 'required|unique:user_core_data,employee_id,' . $core->id,
        ]);

        $dgm->update([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
        ]);

        $core->update([
            'employee_id' => $request->employee_id,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.approver.index')->with('success', 'Approver DGM updated.');
    }

    public function deleteApproverDgm($id)
    {
        $dgm = ApproverDgm::findOrFail($id);
        $core = $dgm->core;

        $dgm->delete();
        $core->delete();

        return redirect()->route('admin.approver.index')->with('success', 'Approver DGM deleted');
    }

    //Security Manager
    public function indexSecurityManagers()
    {
        $managers = SecurityManager::with(['core', 'approverDgm'])->get();
        return view('admin.security_managers.index', compact('managers'));
    }

    public function createSecurityManager()
    {
        $dgms = ApproverDgm::all();
        return view('admin.security_managers.create', compact('dgms'));
    }

    public function storeSecurityManager(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'required|string|max:255|unique:user_core_data,employee_id',
            'approver_dgm_id' => 'required|exists:approver_dgms,id',
            'password' => 'required|string|min:8|max:20',
        ], [
            'name.required' => 'The name field is required.',
            'employee_id.required' => 'The employee ID is required.',
            'employee_id.unique' => 'This employee ID already exists.',
            'approver_dgm_id.required' => 'You must select an Approver DGM.',
            'approver_dgm_id.exists' => 'The selected Approver DGM is invalid.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not exceed 20 characters.',
        ]);

        $core = UserCoreData::create([
            'employee_id' => $request->employee_id,
            'password' => bcrypt($request->password),
            'role_id' => UserAccessLevel::where('role', 'Security Manager')->value('id'),
            'status' => 'active',
        ]);

        SecurityManager::create([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'approver_dgm_id' => $request->approver_dgm_id,
            'user_core_data_id' => $core->id,
        ]);

        return redirect()->route('admin.security_managers.index')->with('success', 'Security Manager created successfully.');
    }


    public function editSecurityManager($id)
    {
        $manager = SecurityManager::with('core')->findOrFail($id);
        $dgms = ApproverDgm::all();
        return view('admin.security_managers.edit', compact('manager', 'dgms'));
    }

    public function updateSecurityManager(Request $request, $id)
    {
        $manager = SecurityManager::findOrFail($id);
        $core = $manager->core;

        $request->validate([
            'name' => 'required',
            'employee_id' => 'required|unique:user_core_data,employee_id,' . $core->id,
            'approver_dgm_id' => 'required|exists:approver_dgms,id',
        ]);

        $manager->update([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'approver_dgm_id' => $request->approver_dgm_id,
        ]);

        $core->update([
            'employee_id' => $request->employee_id,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.security_managers.index')->with('success', 'Security Manager updated.');
    }

    public function deleteSecurityManager($id)
    {
        $manager = SecurityManager::findOrFail($id);
        $core = $manager->core;

        $manager->delete();
        $core->delete();

        return redirect()->route('admin.security_managers.index')->with('success', 'Security Manager deleted');
    }

    //Patrol Officer
    public function indexPatrolOfficers()
    {
        $officers = PatrolOfficer::with(['core', 'manager'])->get();
        return view('admin.patrol_officers.index', compact('officers'));
    }

    public function createPatrolOfficer()
    {
        $managers = SecurityManager::all();
        $locations = Location::all();
        return view('admin.patrol_officers.create', compact('managers', 'locations'));
    }

    public function storePatrolOfficer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slt_employee_id' => 'required|string|max:255|unique:user_core_data,employee_id',
            'assigned_manager_id' => 'required|exists:security_managers,id',
            'location_id' => 'required|exists:locations,id',
            'password' => 'required|string|min:8|max:20',
        ], [
            'name.required' => 'Name is required.',
            'slt_employee_id.required' => 'SLT Employee ID is required.',
            'slt_employee_id.unique' => 'This SLT Employee ID already exists.',
            'assigned_manager_id.required' => 'Please select a Security Manager.',
            'assigned_manager_id.exists' => 'The selected Security Manager is invalid.',
            'location_id.required' => 'Please select a Location.',
            'location_id.exists' => 'The selected Location is invalid.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password must not exceed 20 characters.',
        ]);

        $core = UserCoreData::create([
            'employee_id' => $request->slt_employee_id,
            'password' => bcrypt($request->password),
            'role_id' => UserAccessLevel::where('role', 'Patrol Officer')->value('id'),
            'status' => 'active',
        ]);

        PatrolOfficer::create([
            'name' => $request->name,
            'slt_employee_id' => $request->slt_employee_id,
            'assigned_manager_id' => $request->assigned_manager_id,
            'location_id' => $request->location_id,
            'user_core_data_id' => $core->id,
        ]);

        return redirect()->route('admin.patrol_officers.index')->with('success', 'Patrol Officer created successfully.');
    }


    public function editPatrolOfficer($id)
    {
        $officer   = PatrolOfficer::findOrFail($id);
        $managers  = SecurityManager::all();
        $locations = Location::all(); // ✅ must pass this too

        return view('admin.patrol_officers.edit', compact('officer', 'managers', 'locations'));
    }


    public function updatePatrolOfficer(Request $request, $id)
    {
        $officer = PatrolOfficer::findOrFail($id);
        $core = $officer->core;

        $request->validate([
            'name' => 'required',
            'slt_employee_id' => 'required|unique:user_core_data,employee_id,' . $core->id,
            'assigned_manager_id' => 'required|exists:security_managers,id',
            'location_id' => 'required|exists:locations,id', // ✅ Add validation
        ]);

        $officer->update([
            'name' => $request->name,
            'slt_employee_id' => $request->slt_employee_id,
            'assigned_manager_id' => $request->assigned_manager_id,
            'location_id' => $request->location_id, // ✅ Add update here
        ]);

        $core->update([
            'employee_id' => $request->slt_employee_id,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.patrol_officers.index')->with('success', 'Patrol Officer updated.');
    }


    public function deletePatrolOfficer($id)
    {
        $officer = PatrolOfficer::findOrFail($id);
        $core = $officer->core;

        $officer->delete();
        $core->delete();

        return redirect()->route('admin.patrol_officers.index')->with('success', 'Patrol Officer deleted');
    }

    //Security Officer

    public function indexSecurityOfficers(Request $request)
{
    $query = SecurityOfficer::with(['core', 'company', 'patrol', 'location']);

    if ($request->filled('patrol_id')) {
        $query->where('assigned_patrol_id', $request->patrol_id);
    }

    if ($request->filled('location_id')) {
        $query->where('location_id', $request->location_id);
    }

    $officers = $query->get();
    $patrols = PatrolOfficer::all();
    $locations = Location::all();

    return view('admin.security_officers.index', compact('officers', 'patrols', 'locations'));
}


    public function createSecurityOfficer()
{
    $companies = Company::all();
    $patrols = PatrolOfficer::all();
    $titles = \App\Models\SecurityOfficerTitle::all(); 
    return view('admin.security_officers.create', compact('companies', 'patrols', 'titles'));
}

    public function storeSecurityOfficer(Request $request)
{
    $request->validate([
        'title_id' => 'required|exists:security_officer_titles,id',
        'name' => 'required',
        'nic' => 'required|unique:security_officers,nic',
        'service_no_input' => 'required',
        'telephone' => 'required',
        'address' => 'required',
        'nic_photo_front' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'nic_photo_back' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'company_id' => 'required|exists:companies,id',
        'assigned_patrol_id' => 'required|exists:patrol_officers,id',
    ]);

    $nicPhotoPaths = [];

    if ($request->hasFile('nic_photo_front')) {
        $nicPhotoPaths['front'] = $request->file('nic_photo_front')->store('nic_photos', 'public');
    }

    if ($request->hasFile('nic_photo_back')) {
        $nicPhotoPaths['back'] = $request->file('nic_photo_back')->store('nic_photos', 'public');
    }

    $patrolOfficer = \App\Models\PatrolOfficer::findOrFail($request->assigned_patrol_id);
    $locationId = $patrolOfficer->location_id;

    // Generate service number
    $company = \App\Models\Company::findOrFail($request->company_id);
    $prefix = collect(explode(' ', $company->name))->map(fn($word) => strtoupper($word[0]))->implode('');
    $finalServiceNo = $prefix . '/' . $request->service_no_input;

    \App\Models\SecurityOfficer::create([
        'title_id' => $request->title_id,
        'name' => $request->name,
        'nic' => $request->nic,
        'service_number' => $finalServiceNo,
        'telephone' => $request->telephone,
        'address' => $request->address,
        'nic_photo_path' => !empty($nicPhotoPaths) ? json_encode($nicPhotoPaths) : null,
        'company_id' => $request->company_id,
        'assigned_patrol_id' => $request->assigned_patrol_id,
        'location_id' => $locationId,
    ]);

    return redirect()->route('admin.security_officers.index')->with('success', 'Security Officer created successfully.');
}




    public function editSecurityOfficer($id)
{
    $officer = SecurityOfficer::with('core')->findOrFail($id);
    $companies = Company::all();
    $patrols = PatrolOfficer::all();
    $titles = \App\Models\SecurityOfficerTitle::all(); 
    return view('admin.security_officers.edit', compact('officer', 'companies', 'patrols', 'titles'));
}

    public function updateSecurityOfficer(Request $request, $id)
{
    $officer = SecurityOfficer::findOrFail($id);
    $core = $officer->core;

    $request->validate([
        'title_id' => 'required|exists:security_officer_titles,id',
        'name' => 'required',
        'nic' => 'required|unique:security_officers,nic,' . $officer->id,
        'service_no_input' => 'required',
        'telephone' => 'required',
        'address' => 'required',
        'company_id' => 'required|exists:companies,id',
        'assigned_patrol_id' => 'required|exists:patrol_officers,id',
        'nic_photo_front' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'nic_photo_back' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $nicPhotos = json_decode($officer->nic_photo_path, true) ?? [];

    if ($request->has('remove_front') && isset($nicPhotos['front'])) {
        \Storage::disk('public')->delete($nicPhotos['front']);
        unset($nicPhotos['front']);
    }

    if ($request->has('remove_back') && isset($nicPhotos['back'])) {
        \Storage::disk('public')->delete($nicPhotos['back']);
        unset($nicPhotos['back']);
    }

    if ($request->hasFile('nic_photo_front')) {
        $nicPhotos['front'] = $request->file('nic_photo_front')->store('nic_photos', 'public');
    }

    if ($request->hasFile('nic_photo_back')) {
        $nicPhotos['back'] = $request->file('nic_photo_back')->store('nic_photos', 'public');
    }

    $patrolOfficer = \App\Models\PatrolOfficer::findOrFail($request->assigned_patrol_id);
    $locationId = $patrolOfficer->location_id;

    // Rebuild service number
    $company = \App\Models\Company::findOrFail($request->company_id);
    $prefix = collect(explode(' ', $company->name))->map(fn($word) => strtoupper($word[0]))->implode('');
    $finalServiceNo = $prefix . '/' . $request->service_no_input;

    $officer->update([
        'title_id' => $request->title_id,
        'name' => $request->name,
        'nic' => $request->nic,
        'service_number' => $finalServiceNo,
        'telephone' => $request->telephone,
        'address' => $request->address,
        'company_id' => $request->company_id,
        'assigned_patrol_id' => $request->assigned_patrol_id,
        'location_id' => $locationId,
        'nic_photo_path' => json_encode($nicPhotos),
    ]);

    if ($core) {
    $core->update([
        'status' => $request->status ?? 'active',
    ]);
}


    return redirect()->route('admin.security_officers.index')->with('success', 'Security Officer updated successfully.');
}



    public function deleteSecurityOfficer($id)
    {
        $officer = SecurityOfficer::findOrFail($id);
        $core = $officer->core;

        $officer->delete();

        if ($core) {
            $core->delete();
        }

        return redirect()->route('admin.security_officers.index')->with('success', 'Security Officer deleted');
    }
}
