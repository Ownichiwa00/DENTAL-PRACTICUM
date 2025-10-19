@extends('layouts.app')

@section('title', 'Forgot Password - ToothTalk Dental Clinic')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #0A7C7D;
    --primary-dark: #065A5C;
    --primary-light: #4DAFB0;
    --accent: #00C2C3;
    --text: #1A2E35;
    --text-light: #5A6D74;
    --bg-light: #F8FCFD;
    --white: #FFFFFF;
    --gray: #E8F0F1;
    --shadow: 0 8px 30px rgba(0,0,0,0.08);
    --transition: all 0.3s ease;
}

body, html {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, var(--bg-light) 0%, #E8F6F7 100%);
    min-height: 100vh;
    margin: 0;
}

.patient-login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.login-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 800px;
    width: 100%;
    background: var(--white);
    border-radius: 20px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.login-section {
    flex: 1 1 400px;
    padding: 50px 40px;
}

.logo {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
}

.logo-img {
    width: 70px;
    height: 70px;
    background: var(--primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-weight: 800;
    font-size: 24px;
}

.logo-text h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 5px;
}

.logo-text p {
    font-size: 14px;
    color: var(--text-light);
    font-weight: 500;
}

.login-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 10px;
}

.login-header p {
    font-size: 16px;
    color: var(--text-light);
    margin-bottom: 30px;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: 600;
    font-size: 14px;
    color: var(--text);
}

.form-group input {
    padding: 12px 15px;
    font-size: 16px;
    border: 2px solid var(--gray);
    border-radius: 10px;
    transition: var(--transition);
}

.form-group input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(10,124,125,0.1);
    outline: none;
}

.login-btn {
    background: var(--primary);
    color: var(--white);
    border: none;
    padding: 15px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.login-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.back-login {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: var(--text-light);
}

.back-login a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
}

.back-login a:hover {
    text-decoration: underline;
}

.message { padding: 12px 15px; border-radius: 8px; font-weight: 500; }
.message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.image-section {
    flex: 1 1 400px;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    color: var(--white);
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    padding: 40px;
}

.image-content {
    text-align: center;
}

.image-content h3 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
}

.image-content p {
    font-size: 16px;
    opacity: 0.9;
}

.back-home {
    position: absolute;
    top: 20px;
    left: 20px;
}

.back-home a {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    text-decoration: none;
    color: var(--white);
}

@media (max-width: 768px) {
    .login-container { flex-direction: column; }
    .image-section { display: none; }
    .login-section { padding: 30px 25px; }
}
</style>

<div class="patient-login-container">
    <div class="login-container">
        <div class="login-section">
            <div class="logo">
                <div class="logo-img">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="ToothTalk Logo">
                    @else
                        TT
                    @endif
                </div>
                <div class="logo-text">
                    <h1>ToothTalk</h1>
                    <p>JValera Dental Clinic</p>
                </div>
            </div>

            <div class="login-header">
                <h2>Forgot Password</h2>
                <p>Enter your email to receive a password reset link</p>
            </div>

            @if(session('success'))
                <div class="message success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="message error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('patient.password.request') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-btn">Send Reset Link</button>

                <div class="back-login">
                    <a href="{{ route('patient.login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            </form>
        </div>

        <div class="image-section">
            <div class="back-home">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </div>
            <div class="image-content">
                <h3>Secure Your Account</h3>
                <p>We’ll send a secure link to your registered email to reset your password.</p>
            </div>
        </div>
    </div>
</div>
@endsection
