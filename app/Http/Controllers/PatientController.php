<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Mail\PatientResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    public function showLogin(): View
    {
        return view('patient.login');
    }

    public function showRegister(): View
    {
        return view('patient.registration');
    }

    public function showForgotPasswordForm(): View
    {
        return view('patient.forgot-password');
    }

    public function sendForgotPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:patients,email',
        ]);

        $patient = Patient::where('email', $request->email)->first();

        $broker = Password::broker('patients');
        $token = $broker->createToken($patient);

        $resetLink = url('/patient/reset-password?token=' . $token . '&email=' . urlencode($patient->email));

        Mail::to($patient->email)->send(new PatientResetPasswordMail($resetLink));

        return back()->with('success', 'A password reset link has been sent to your email.');
    }

    public function showResetPasswordForm(Request $request): View|RedirectResponse
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()->route('patient.login')->with('error', 'Invalid password reset link.');
        }

        return view('patient.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:patients,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::broker('patients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Patient $patient, string $password) {
                $patient->password = Hash::make($password);
                $patient->setRememberToken(Str::random(60));
                $patient->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('patient.login')->with('success', 'Password has been reset successfully.');
        } else {
            return back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $patient = Patient::where('username', $request->username)->first();

        if ($patient && Hash::check($request->password, $patient->password)) {
            session([
                'patient_logged_in' => true,
                'patient_id' => $patient->id,
                'patient_name' => $patient->first_name . ' ' . $patient->last_name,
                'patient_username' => $patient->username,
            ]);

            return redirect()->route('patient.records')
                ->with('success', 'Welcome back, ' . $patient->first_name . '!');
        }

        return back()->withErrors(['username' => 'Invalid username or password.'])
                     ->withInput($request->only('username'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('patient.login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other,prefer-not-to-say',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:50',
        ]);

        $baseUsername = 'PATIENT-' . strtoupper($request->last_name);
        $username = $baseUsername;
        $counter = 1;

        while (Patient::where('username', $username)->exists()) {
            $username = $baseUsername . '-' . $counter;
            $counter++;
        }

        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $username,
            'password' => Hash::make($request->password),
            'address' => $request->address ?? null,
            'emergency_contact' => $request->emergency_contact ?? null,
        ]);

        session([
            'patient_logged_in' => true,
            'patient_id' => $patient->id,
            'patient_name' => $patient->first_name . ' ' . $patient->last_name,
            'patient_username' => $patient->username,
        ]);

        return redirect()->route('patient.login')
            ->with('success', 'Registration successful! Your username is: ' . $patient->username);
    }

    public function dashboard(): View|RedirectResponse
    {
        if (!session('patient_logged_in')) {
            return redirect()->route('patient.login');
        }

        $patient = Patient::find(session('patient_id'));

        return view('patient.dashboard', [
            'patient' => $patient,
            'username' => session('patient_username'),
        ]);
    }

    public function records(): View|RedirectResponse
    {
        if (!session('patient_logged_in')) {
            return redirect()->route('patient.login');
        }

        $records = [
            (object)['id' => 1, 'form_name' => 'Patient Record & Chart', 'date' => now()->subMonths(3)],
            (object)['id' => 2, 'form_name' => 'Progress Notes (Month 1)', 'date' => now()->subMonths(2)],
        ];

        $patient = Patient::find(session('patient_id'));

        return view('patient.records', compact('records', 'patient'));
    }

    public function viewRecord(int $id): JsonResponse|RedirectResponse
    {
        if (!session('patient_logged_in')) {
            return redirect()->route('patient.login');
        }

        return response()->json(['message' => 'Record viewed successfully']);
    }

    public function downloadRecord(int $id): JsonResponse|RedirectResponse
    {
        if (!session('patient_logged_in')) {
            return redirect()->route('patient.login');
        }

        return response()->json(['message' => 'Record download initiated']);
    }

    public function storeMedicalClearance(Request $request): RedirectResponse
    {
        if (!session('patient_logged_in')) {
            return redirect()->route('patient.login');
        }

        $request->validate([
            'patient_grade' => 'required|string|max:255',
            'medical_conditions' => 'required|array|min:1',
            'medical_conditions.*' => 'string',
            'medical_conditions_desc' => 'required|string|min:10',
            'medical_history' => 'nullable|array',
            'medical_history.*' => 'string'
        ]);

        return redirect()->route('patient.records')
            ->with('success', 'Medical clearance form submitted successfully!');
    }

    public function storeAdvanced(Request $request): RedirectResponse
    {
        if (!session('patient_logged_in')) {
            return redirect()->route('patient.login');
        }

        $request->validate([
            'field_one' => 'required|string|max:255',
            'field_two' => 'nullable|string',
        ]);

        return redirect()->route('patient.records')
            ->with('success', 'Advanced form submitted successfully!');
    }
}
