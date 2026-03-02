<?php

use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DevotionalController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\PrayerRequestController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/renungan', [HomeController::class , 'devotionals'])->name('public.devotionals');
Route::get('/warta', [HomeController::class , 'announcements'])->name('public.announcements');
Route::get('/jadwal', [HomeController::class , 'schedules'])->name('public.schedules');
Route::get('/galeri', [HomeController::class , 'gallery'])->name('public.gallery');
Route::get('/permohonan-doa', [HomeController::class , 'prayerRequest'])->name('public.prayer_request');
Route::post('/permohonan-doa', [HomeController::class , 'storePrayerRequest'])->name('public.prayer_request.store');

// Admin Routes (Protected by auth, admin, and audit middleware)
Route::middleware(['auth', 'admin', 'audit'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class , 'index'])->name('dashboard');

    Route::resource('members', MemberController::class)->middleware('permission:members.manage');
    Route::resource('families', FamilyController::class)->middleware('permission:families.manage');
    Route::post('families/{family}/add-member', [FamilyController::class , 'addMember'])
        ->name('families.add_member')
        ->middleware('permission:families.manage');
    Route::delete('families/{family}/remove-member/{member}', [FamilyController::class , 'removeMember'])
        ->name('families.remove_member')
        ->middleware('permission:families.manage');

    Route::resource('transactions', TransactionController::class)->middleware('permission:transactions.manage');
    Route::resource('announcements', AnnouncementController::class)->middleware('permission:announcements.manage');
    Route::resource('devotionals', DevotionalController::class)->middleware('permission:devotionals.manage');
    Route::resource('schedules', ScheduleController::class)->middleware('permission:schedules.manage');
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class)->middleware('permission:sliders.manage');
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class)->middleware('permission:gallery.manage');

    // Prayer Requests Admin
    Route::get('prayer-requests', [PrayerRequestController::class , 'index'])
        ->name('prayer_requests.index')
        ->middleware('permission:prayer_requests.manage');
    Route::patch('prayer-requests/{prayerRequest}', [PrayerRequestController::class , 'updateStatus'])
        ->name('prayer_requests.update_status')
        ->middleware('permission:prayer_requests.manage');
    Route::delete('prayer-requests/{prayerRequest}', [PrayerRequestController::class , 'destroy'])
        ->name('prayer_requests.destroy')
        ->middleware('permission:prayer_requests.manage');

    // Reports Admin
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class , 'index'])
        ->name('reports.index')
        ->middleware('permission:reports.view');
    Route::get('reports/membership', [\App\Http\Controllers\Admin\ReportController::class , 'membership'])
        ->name('reports.membership')
        ->middleware('permission:reports.view');
    Route::get('reports/finance', [\App\Http\Controllers\Admin\ReportController::class , 'finance'])
        ->name('reports.finance')
        ->middleware('permission:reports.view');

    Route::get('profile', [\App\Http\Controllers\Admin\ChurchProfileController::class , 'edit'])
        ->name('profile.edit')
        ->middleware('permission:profile.manage');
    Route::put('profile', [\App\Http\Controllers\Admin\ChurchProfileController::class , 'update'])
        ->name('profile.update')
        ->middleware('permission:profile.manage');

    Route::get('audit-logs', [AuditLogController::class, 'index'])
        ->name('audit_logs.index')
        ->middleware('permission:audit_logs.view');

    Route::get('roles-permissions', [RolePermissionController::class, 'index'])
        ->name('roles_permissions.index')
        ->middleware('permission:roles.manage');
    Route::post('roles-permissions', [RolePermissionController::class, 'update'])
        ->name('roles_permissions.update')
        ->middleware('permission:roles.manage');
    Route::post('roles-permissions/roles', [RolePermissionController::class, 'storeRole'])
        ->name('roles_permissions.roles.store')
        ->middleware('permission:roles.manage');
    Route::put('roles-permissions/roles/{role}', [RolePermissionController::class, 'updateRole'])
        ->name('roles_permissions.roles.update')
        ->middleware('permission:roles.manage');
    Route::delete('roles-permissions/roles/{role}', [RolePermissionController::class, 'destroyRole'])
        ->name('roles_permissions.roles.destroy')
        ->middleware('permission:roles.manage');
    Route::post('roles-permissions/permissions', [RolePermissionController::class, 'storePermission'])
        ->name('roles_permissions.permissions.store')
        ->middleware('permission:roles.manage');
    Route::put('roles-permissions/permissions/{permission}', [RolePermissionController::class, 'updatePermission'])
        ->name('roles_permissions.permissions.update')
        ->middleware('permission:roles.manage');
    Route::delete('roles-permissions/permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])
        ->name('roles_permissions.permissions.destroy')
        ->middleware('permission:roles.manage');
    Route::post('roles-permissions/assign', [RolePermissionController::class, 'assignRoleToUser'])
        ->name('roles_permissions.assign')
        ->middleware('permission:roles.manage');

    Route::get('users', [UserController::class, 'index'])
        ->name('users.index')
        ->middleware('permission:users.manage');
    Route::put('users/{user}/roles', [UserController::class, 'updateRoles'])
        ->name('users.roles.update')
        ->middleware('permission:users.manage');
});

require __DIR__ . '/auth.php';
