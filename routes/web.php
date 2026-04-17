<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\PatrolOfficer\TimecardController;
use App\Http\Controllers\SecurityManagerController;
use App\Http\Controllers\Company\CompanyUserController;

Route::get('/', fn() => redirect()->route('login'));

//Google Authentication
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Forgot and Reset Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');



// ==========================
// 🔐 Authentication Routes
// ==========================

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// ==================================
// 🧑‍💼 General Dashboard Per Role
// These are fallback test dashboards
// ==================================
Route::middleware(['auth'])->group(function () {
    Route::get('company/dashboard', [CompanyUserController::class,'index'])->name('company.dashboard');
    Route::get('approverdgm/dashboard', fn() => 'Approver DGM Dashboard')->name('approverdgm.dashboard');
    Route::get('manager/dashboard', [SecurityManagerController::class,'index'])->name('manager.dashboard');
    Route::get('/patrol/timecards', [TimecardController::class, 'index'])->name('petrol.timecards.index');
    Route::get('security/dashboard', fn() => 'Security Officer Dashboard')->name('security.dashboard');
    Route::get('patrol/dashboard', fn() => view('patrol_officer.dashboard'))->name('patrol.dashboard');
});



// ===============================
// 🛠️ Admin Routes (Role ID = 1)
// ===============================
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':1'])->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // Companies
    Route::get('companies', [CompanyController::class, 'index'])->name('admin.companies.index');
    Route::get('companies/create', [CompanyController::class, 'create'])->name('admin.companies.create');
    Route::post('companies/store', [CompanyController::class, 'store'])->name('admin.companies.store');
    Route::get('companies/edit/{id}', [CompanyController::class, 'edit'])->name('admin.companies.edit');
    Route::put('companies/update/{id}', [CompanyController::class, 'update'])->name('admin.companies.update');
    Route::post('companies/update/{id}', [CompanyController::class, 'update'])->name('admin.companies.update');
    Route::delete('companies/delete/{id}', [CompanyController::class, 'destroy'])->name('admin.companies.delete');

    // Company Users
    Route::get('company-users', [UserManagementController::class, 'indexCompanyUsers'])->name('admin.company_users.index');
    Route::get('company-users/create', [UserManagementController::class, 'createCompanyUser'])->name('admin.company_users.create');
    Route::post('company-users/store', [UserManagementController::class, 'storeCompanyUser'])->name('admin.company_users.store');
    Route::get('company-users/edit/{id}', [UserManagementController::class, 'editCompanyUser'])->name('admin.company_users.edit');
    Route::post('company-users/update/{id}', [UserManagementController::class, 'updateCompanyUser'])->name('admin.company_users.update');
    Route::delete('company-users/delete/{id}', [UserManagementController::class, 'deleteCompanyUser'])->name('admin.company_users.delete');

    // Approver DGMs
    Route::get('approvers', [UserManagementController::class, 'indexApproverDgms'])->name('admin.approver.index');
    Route::get('approvers/create', [UserManagementController::class, 'createApproverDgm'])->name('admin.approver.create');
    Route::post('approvers/store', [UserManagementController::class, 'storeApproverDgm'])->name('admin.approver.store');
    Route::get('approvers/edit/{id}', [UserManagementController::class, 'editApproverDgm'])->name('admin.approver.edit');
    Route::post('approvers/update/{id}', [UserManagementController::class, 'updateApproverDgm'])->name('admin.approver.update');
    Route::delete('approvers/delete/{id}', [UserManagementController::class, 'deleteApproverDgm'])->name('admin.approver.delete');

    // Security Managers
    Route::get('security-managers', [UserManagementController::class, 'indexSecurityManagers'])->name('admin.security_managers.index');
    Route::get('security-managers/create', [UserManagementController::class, 'createSecurityManager'])->name('admin.security_managers.create');
    Route::post('security-managers/store', [UserManagementController::class, 'storeSecurityManager'])->name('admin.security_managers.store');
    Route::get('security-managers/edit/{id}', [UserManagementController::class, 'editSecurityManager'])->name('admin.security_managers.edit');
    Route::post('security-managers/update/{id}', [UserManagementController::class, 'updateSecurityManager'])->name('admin.security_managers.update');
    Route::delete('security-managers/delete/{id}', [UserManagementController::class, 'deleteSecurityManager'])->name('admin.security_managers.delete');

    // Patrol Officers
    Route::get('patrol-officers', [UserManagementController::class, 'indexPatrolOfficers'])->name('admin.patrol_officers.index');
    Route::get('patrol-officers/create', [UserManagementController::class, 'createPatrolOfficer'])->name('admin.patrol_officers.create');
    Route::post('patrol-officers/store', [UserManagementController::class, 'storePatrolOfficer'])->name('admin.patrol_officers.store');
    Route::get('patrol-officers/edit/{id}', [UserManagementController::class, 'editPatrolOfficer'])->name('admin.patrol_officers.edit');
    Route::post('patrol-officers/update/{id}', [UserManagementController::class, 'updatePatrolOfficer'])->name('admin.patrol_officers.update');
    Route::delete('patrol-officers/delete/{id}', [UserManagementController::class, 'deletePatrolOfficer'])->name('admin.patrol_officers.delete');

    // Security Officers
    Route::get('security-officers', [UserManagementController::class, 'indexSecurityOfficers'])->name('admin.security_officers.index');
    Route::get('security-officers/create', [UserManagementController::class, 'createSecurityOfficer'])->name('admin.security_officers.create');
    Route::post('security-officers/store', [UserManagementController::class, 'storeSecurityOfficer'])->name('admin.security_officers.store');
    Route::get('security-officers/edit/{id}', [UserManagementController::class, 'editSecurityOfficer'])->name('admin.security_officers.edit');
    Route::post('security-officers/update/{id}', [UserManagementController::class, 'updateSecurityOfficer'])->name('admin.security_officers.update');
    Route::put('security-officers/update/{id}', [UserManagementController::class, 'updateSecurityOfficer'])->name('admin.security_officers.update');
    Route::delete('security-officers/delete/{id}', [UserManagementController::class, 'deleteSecurityOfficer'])->name('admin.security_officers.delete');

    Route::resource('locations', App\Http\Controllers\Admin\LocationController::class);
});

// ===============================
// 🛠️ Company User Routes (Role ID = 2)
// ===============================

Route::middleware(['auth'])->prefix('company')->group(function () {
    Route::get('/timecards', [CompanyUserController::class, 'timecardsIndex'])->name('company.timecards.index');
    Route::get('/timecards/pdf', [CompanyUserController::class, 'downloadPdf'])->name('company.timecards.pdf');
});


// ===============================
// 🛠️ Approver Routes (Role ID = 3)
// ===============================



// ===============================
// 🛠️ Security Manager Routes (Role ID = 4)
// ===============================



// ===============================
// 🛠️ Patrol Leader Routes (Role ID = 5)
// ===============================

Route::prefix('patrol')->middleware(['auth'])->group(function () {
    Route::get('/timecards', [TimecardController::class, 'index'])->name('patrol.timecards.index');
    Route::post('/timecards', [TimecardController::class, 'store'])->name('patrol.timecards.store');
    Route::put('/timecards/{id}', [TimecardController::class, 'update'])->name('patrol.timecards.update');
    Route::get('/timecards/pdf/{date}', [TimecardController::class, 'generatePdf'])->name('patrol.timecards.pdf');
    Route::delete('/timecards/{id}', [TimecardController::class, 'destroy'])->name('patrol.timecards.destroy');
    Route::get('/monthly-attendance', [TimecardController::class, 'download'])
    ->name('patrol.attendance.download');
    
});
Route::get('/patrol/timecards/check/{date}', [TimecardController::class, 'checkGuardsByDate'])->name('patrol.timecards.check');


Route::middleware(['auth'])->prefix('security_manager')->name('security_manager.')->group(function () {
    Route::post('/timecards/{id}', [SecurityManagerController::class, 'update'])->name('timecards.update');
    Route::delete('/timecards/{id}', [SecurityManagerController::class, 'destroy'])->name('timecards.destroy');
});

Route::get('/patrol/monthly-attendance', [TimecardController::class, 'download'])
    ->name('patrol.attendance.download');


// ===========================
// To fetch monthly count 
// ===========================

    Route::get('/patrol/monthly-attendance-counts', [TimecardController::class, 'monthlyAttendanceCounts'])
    ->name('patrol.attendance.counts');

    // serch for petroll officer
    Route::get('/patrol/search-guards', [TimecardController::class, 'searchGuards'])->name('patrol.guards.search');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('locations', App\Http\Controllers\Admin\LocationController::class);
});
