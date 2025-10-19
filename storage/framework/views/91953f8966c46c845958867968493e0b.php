

<?php $__env->startSection('title', 'Patient Records - ToothTalk Dental Clinic'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .main-content {
        padding: 40px 0;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 10px;
    }

    .page-subtitle {
        font-size: 16px;
        color: var(--text-light);
    }

    .records-section,
    .forms-section {
        background: var(--white);
        border-radius: 15px;
        box-shadow: var(--shadow);
        padding: 30px;
        margin-bottom: 40px;
    }

    .section-title,
    .form-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .records-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    .records-table th,
    .records-table td {
        padding: 15px;
        font-size: 14px;
        border-bottom: 1px solid var(--gray);
    }

    .records-table th {
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid var(--gray);
    }

    .records-table tr:hover {
        background: rgba(10, 124, 125, 0.05);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        text-decoration: none;
    }

    .btn-view {
        background: rgba(10, 124, 125, 0.1);
        color: var(--primary);
    }

    .btn-view:hover {
        background: rgba(10, 124, 125, 0.2);
    }

    .btn-download {
        background: rgba(46, 204, 113, 0.1);
        color: #2ECC71;
    }

    .btn-download:hover {
        background: rgba(46, 204, 113, 0.2);
    }

    .form-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--gray);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text);
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--gray);
        border-radius: 10px;
        font-size: 14px;
        transition: var(--transition);
        background: var(--white);
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(10, 124, 125, 0.15);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-item input {
        width: 18px;
        height: 18px;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--gray);
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-label {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
        padding: 12px 24px;
        font-size: 16px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10, 124, 125, 0.25);
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(46, 204, 113, 0.1);
        color: #2ECC71;
        border-left: 4px solid #2ECC71;
    }

    .alert-error {
        background: rgba(231, 76, 60, 0.1);
        color: #E74C3C;
        border-left: 4px solid #E74C3C;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .checkbox-group {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 28px;
        }

        .records-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Patient Records Portal</h1>
            <p class="page-subtitle">Access and manage your dental health records and medical forms</p>
        </div>

        
        <div class="records-section">
            <h2 class="section-title">
                <i class="fas fa-file-medical"></i>
                PATIENT RECORDS
            </h2>
            <div class="table-responsive">
                <table class="records-table">
                    <thead>
                        <tr>
                            <th>FORM</th>
                            <th>DATE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($records) && count($records) > 0): ?>
                            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($record->form_name); ?></td>
                                    <td><?php echo e($record->date->format('m/d/Y')); ?></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-view" type="button" data-id="<?php echo e($record->id); ?>">
                                            <i class="fas fa-eye"></i> VIEW
                                        </button>
                                        <button class="btn btn-download" type="button" data-id="<?php echo e($record->id); ?>">
                                            <i class="fas fa-download"></i> DOWNLOAD
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align:center;">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="forms-section">
            <h2 class="form-title">Dental Medical Clearance Form</h2>

            <form id="medical-clearance-form" method="POST" action="#">
                <?php echo csrf_field(); ?>
                <div class="form-section">
                    <h3 class="section-label">
                        <i class="fas fa-user"></i>
                        Patient Information
                    </h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient-name">Name</label>
                            <input type="text" id="patient-name" class="form-control" value="John Doe" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patient-grade">Grade</label>
                            <input type="text" id="patient-grade" class="form-control" placeholder="Enter grade">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient-dob">Date of birth</label>
                            <input type="date" id="patient-dob" class="form-control" value="1995-01-01" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patient-contact">Contact number</label>
                            <input type="tel" id="patient-contact" class="form-control" value="09171234567" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="patient-address">Address</label>
                        <input type="text" id="patient-address" class="form-control" value="123 Test Street, Manila" readonly>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-label">
                        <i class="fas fa-file-medical-alt"></i>
                        Reason for Medical Clearance
                    </h3>
                    <div class="form-group">
                        <label>Medical Conditions (Check all that apply)</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="condition1">
                                <label for="condition1">Condition 1</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="condition2">
                                <label for="condition2">Condition 2</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-label">
                        <i class="fas fa-history"></i>
                        Medical History
                    </h3>
                    <div class="form-group">
                        <label for="medical-conditions">Medical conditions</label>
                        <textarea id="medical-conditions" class="form-control" rows="3" placeholder="Describe any medical conditions"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Medical History (Check all that apply)</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="history1">
                                <label for="history1">History 1</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="history2">
                                <label for="history2">History 2</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Medical Clearance Form
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Event delegation for all buttons
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function() {
            const recordId = this.dataset.id;
            viewRecord(recordId);
        });
    });

    document.querySelectorAll('.btn-download').forEach(btn => {
        btn.addEventListener('click', function() {
            const recordId = this.dataset.id;
            downloadRecord(recordId);
        });
    });

    function viewRecord(recordId) {
        alert(`Opening record ID: ${recordId}`);
    }

    function downloadRecord(recordId) {
        alert(`Downloading record ID: ${recordId}`);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\GINO\Desktop\TOOTHTALK_FIXED\resources\views/patient/records.blade.php ENDPATH**/ ?>