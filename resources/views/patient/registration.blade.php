@extends('layouts.app')

@section('title', 'Patient Registration - ToothTalk Dental Clinic')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #0A7C7D;
    --primary-dark: #065A5C;
    --primary-light: #4DAFB0;
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
    max-width: 1000px;
    width: 100%;
    background: var(--white);
    border-radius: 20px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.login-section {
    flex: 1 1 450px;
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
    overflow: hidden;
}

.logo-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
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

.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px 15px;
    font-size: 16px;
    border: 2px solid var(--gray);
    border-radius: 10px;
    transition: var(--transition);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(10,124,125,0.1);
    outline: none;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    border: none;
    background: none;
    cursor: pointer;
    font-size: 18px;
    color: var(--primary);
}

.register-btn {
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

.register-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.login-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: var(--text-light);
}

.login-link a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}

.image-section {
    flex: 1 1 450px;
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
    .login-container {
        flex-direction: column;
    }
    .image-section {
        display: none;
    }
    .login-section {
        padding: 30px 25px;
    }
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
                <h2>Patient Registration</h2>
                <p>Create a new patient account to access your portal and manage your dental records.</p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('username'))
                        <br>Your generated username is: <strong>{{ session('username') }}</strong>
                    @endif
                    <br>Please <a href="{{ route('patient.login') }}">login here</a> using your credentials.
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="text-red-500 mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('patient.register.submit') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                        <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                        <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
                        <option value="prefer-not-to-say" {{ old('gender')=='prefer-not-to-say'?'selected':'' }}>Prefer not to say</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter your current address">{{ old('address') }}</textarea>
                </div>

                <div class="form-group" style="position:relative;">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="toggle-password"><i class="fas fa-eye"></i></button>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="terms" name="terms" {{ old('terms')?'checked':'' }}>
                    <label for="terms">I accept the terms and conditions</label>
                </div>

                <button type="submit" class="register-btn">Register</button>

                <div class="login-link">
                    <p>Already have an account? <a href="{{ route('patient.login') }}">Login here</a></p>
                </div>
            </form>
        </div>

        <div class="image-section">
            <div class="back-home">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </div>
            <div class="image-content">
                <h3>Welcome to ToothTalk</h3>
                <p>Start your dental health journey and manage your appointments online with ease.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.toggle-password');
    if(toggle){
        toggle.addEventListener('click', function(){
            const pwd = document.getElementById('password');
            const icon = this.querySelector('i');
            if(pwd.type === 'password'){
                pwd.type = 'text';
                icon.classList.replace('fa-eye','fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.replace('fa-eye-slash','fa-eye');
            }
        });
    }
});
</script>
@endsection
