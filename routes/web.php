<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostProcedureFormController;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/clinic', [HomeController::class, 'index'])->name('clinic');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/announcement', fn() => view('announcement'))->name('announcement');

// Redirect default /login to patient login
Route::get('/login', fn() => redirect()->route('patient.login'))->name('login');

// ----------------- PATIENT ROUTES -----------------
Route::prefix('patient')->group(function () {
    // Public routes
    Route::get('/login', [PatientController::class, 'showLogin'])->name('patient.login');
    Route::post('/login', [PatientController::class, 'login'])->name('patient.login.submit');
    Route::get('/register', [PatientController::class, 'showRegister'])->name('patient.register');
    Route::post('/register', [PatientController::class, 'register'])->name('patient.register.submit');
    Route::get('/forgot-password', [PatientController::class, 'showForgotPasswordForm'])->name('patient.password.request');
    Route::post('/forgot-password', [PatientController::class, 'sendForgotPassword'])->name('patient.password.email');

    // Password reset routes
    Route::get('/reset-password/{token}', function ($token) {
        return view('patient.reset-password', ['token' => $token]);
    })->name('patient.password.reset');

    Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:patients,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = \Illuminate\Support\Facades\Password::broker('patients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($patient, $password) {
                $patient->password = $password; // hashed automatically in model
                $patient->save();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
            ? redirect()->route('patient.login')->with('success', 'Password has been reset successfully!')
            : back()->withErrors(['email' => [__($status)]]);
    })->name('patient.password.update');

    // Protected routes
    Route::middleware(['patient.auth'])->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
        Route::get('/records', [PatientController::class, 'records'])->name('patient.records');
        Route::get('/records/{id}/view', [PatientController::class, 'viewRecord'])->name('patient.records.view');
        Route::get('/records/{id}/download', [PatientController::class, 'downloadRecord'])->name('patient.records.download');
        Route::post('/medical-clearance', [PatientController::class, 'storeMedicalClearance'])->name('patient.medical-clearance.store');
        Route::post('/advanced-form', [PatientController::class, 'storeAdvanced'])->name('patient.advanced.store');
        Route::post('/logout', [PatientController::class, 'logout'])->name('patient.logout');
    });
});

// ----------------- STAFF ROUTES -----------------
Route::prefix('staff')->group(function () {
    Route::get('/login', [StaffController::class, 'showLogin'])->name('staff.login');
    Route::post('/login', [StaffController::class, 'login'])->name('staff.login.submit');
    Route::post('/logout', [StaffController::class, 'logout'])->name('staff.logout');

    Route::middleware(['staff.auth'])->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        Route::get('/schedule', [StaffController::class, 'schedule'])->name('staff.schedule');
        Route::get('/patients', [StaffController::class, 'patients'])->name('staff.patients');
    });
});

// ----------------- ADMIN ROUTES -----------------
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/patients', [AdminController::class, 'patients'])->name('admin.patients');
        Route::get('/schedule', [AdminController::class, 'schedule'])->name('admin.schedule');
        Route::get('/procedures', [AdminController::class, 'procedures'])->name('admin.procedures');
        Route::get('/content', [AdminController::class, 'content'])->name('admin.content');

        Route::put('/announcement/update', [ContentController::class, 'updateAnnouncement'])->name('admin.announcement.update');
        Route::put('/mail-templates/update', [ContentController::class, 'updateMailTemplate'])->name('admin.mail-templates.update');
        Route::resource('services', ContentController::class);

        Route::get('/patients/{id}/info', [AdminController::class, 'viewPatientInfo'])->name('admin.patients.info');
        Route::get('/patients/{id}/edit', [AdminController::class, 'editPatientInfo'])->name('admin.patients.edit');
        Route::get('/patients/{id}/history', [AdminController::class, 'viewPatientHistory'])->name('admin.patients.history');
        Route::get('/patients/{id}/history/edit', [AdminController::class, 'editPatientHistory'])->name('admin.patients.history.edit');
        Route::put('/patients/{id}/progress-notes', [AdminController::class, 'updateProgressNotes'])->name('admin.patients.progress-notes');
        Route::delete('/patients/{id}/files', [AdminController::class, 'clearPatientFiles'])->name('admin.patients.files.clear');
        Route::delete('/patients/{id}', [AdminController::class, 'destroyPatient'])->name('admin.patients.destroy');

        Route::resource('post-procedure', PostProcedureFormController::class);
        Route::get('/post-procedures', [PostProcedureFormController::class, 'index'])->name('admin.post-procedures.list');
    });
});

// ----------------- AUTH ROUTES -----------------
Route::prefix('auth')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::put('/update-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

// ----------------- APPOINTMENTS -----------------
Route::prefix('appointments')->group(function () {
    Route::get('/tracker', [AppointmentController::class, 'tracker'])->name('appointments.tracker');
    Route::post('/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
});

// ----------------- FALLBACK -----------------
Route::fallback(fn() => redirect()->route('home')->with('error', 'Page not found.'));
