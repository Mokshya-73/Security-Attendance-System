<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Log;


class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        Log::info('🔥 Incoming Company Store Request', $request->all());

        try {
            $company = new Company();
            $company->brn = $request->brn;
            $company->name = $request->name;
            $company->contact_person = $request->contact_person;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->website = $request->website;
            $company->license_number = $request->license_number;
            $company->license_expiry = $request->license_expiry;
            $company->save();

            Log::info('✅ Company created with ID: ' . $company->id);

            return redirect()->route('admin.companies.index')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            Log::error('❌ Company save failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create company: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'brn' => 'required|unique:companies,brn,' . $company->id,
            'name' => 'required',
            'contact_person' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'website' => 'nullable|url',
            'license_number' => 'nullable',
            'license_expiry' => 'nullable|date',
        ]);

        $company->update($request->all());

        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully.');
    }
}
