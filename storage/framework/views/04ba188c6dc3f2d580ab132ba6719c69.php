

<?php $__env->startSection('title', 'Patient Login - ToothTalk Dental Clinic'); ?>

<?php $__env->startSection('content'); ?>
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

.password-container {
    position: relative;
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

.employee-login-btn {
    background: var(--accent);
    color: var(--white);
    border: none;
    padding: 15px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 10px;
}

.employee-login-btn:hover {
    background: var(--primary);
    transform: translateY(-2px);
}

.register-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: var(--text-light);
}

.register-link a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
}

.register-link a:hover {
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

.alert { padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
.alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.text-danger { color: #dc3545; font-size: 14px; margin-top: 5px; display: block; }

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
                    <?php if(file_exists(public_path('images/logo.png'))): ?>
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="ToothTalk Logo">
                    <?php else: ?>
                        TT
                    <?php endif; ?>
                </div>
                <div class="logo-text">
                    <h1>ToothTalk</h1>
                    <p>JValera Dental Clinic</p>
                </div>
            </div>

            <div class="login-header">
                <h2>Patient Login</h2>
                <p>Access your patient portal to manage appointments and view records</p>
            </div>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('patient.login.submit')); ?>" class="login-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo e(old('username')); ?>" placeholder="Enter your username" required>
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group" style="position:relative;">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-password"><i class="fas fa-eye"></i></button>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label for="remember">Remember me</label>
                </div>

                <div class="forgot-link">
                    <a href="<?php echo e(route('patient.password.request')); ?>">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Login to Patient Portal</button>

                <button type="button" class="employee-login-btn" onclick="redirectToEmployeeLogin()">Employee Login</button>

                <div class="register-link">
                    <p>New patient? <a href="<?php echo e(route('patient.register')); ?>">Register here</a></p>
                </div>
            </form>
        </div>

        <div class="image-section">
            <div class="back-home">
                <a href="<?php echo e(route('home')); ?>"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </div>
            <div class="image-content">
                <h3>Your Dental Health Journey</h3>
                <p>Access your treatment history, upcoming appointments, and personalized care plans</p>
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

function redirectToEmployeeLogin() {
    window.location.href = "<?php echo e(route('staff.login')); ?>";
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\GINO\Desktop\TOOTHTALK_FIXED\resources\views/patient/login.blade.php ENDPATH**/ ?>