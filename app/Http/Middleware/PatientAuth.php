<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PatientAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if patient is logged in
        if (!$request->session()->get('patient_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}
