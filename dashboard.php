<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';
require_login();

$page_title = 'Dashboard';

$totalPatients     = $pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn();
$totalDoctors      = $pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
$todayAppointments = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = CURDATE()");
$todayAppointments->execute();
$todayAppointments = $todayAppointments->fetchColumn();
$pendingBills      = $pdo->query("SELECT COUNT(*) FROM billing WHERE payment_status != 'Paid'")->fetchColumn();

$recentAppointments = $pdo->query("
    SELECT a.appointment_id, p.full_name AS patient_name, d.full_name AS doctor_name,
           a.appointment_date, a.appointment_time, a.status
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    JOIN doctors d ON a.doctor_id = d.doctor_id
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
    LIMIT 5
")->fetchAll();

$lowStock = $pdo->query("SELECT item_name, quantity FROM inventory WHERE quantity < 50 ORDER BY quantity ASC LIMIT 5")->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fa-solid fa-gauge"></i> Dashboard</h3>
    <span class="text-muted"><?php echo date('l, d F Y'); ?></span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-blue d-flex justify-content-between align-items-center">
            <div>
                <small>Total Patients</small>
                <h3><?php echo (int)$totalPatients; ?></h3>
            </div>
            <i class="fa-solid fa-bed-pulse"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-green d-flex justify-content-between align-items-center">
            <div>
                <small>Total Doctors</small>
                <h3><?php echo (int)$totalDoctors; ?></h3>
            </div>
            <i class="fa-solid fa-user-doctor"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-orange d-flex justify-content-between align-items-center">
            <div>
                <small>Today's Appointments</small>
                <h3><?php echo (int)$todayAppointments; ?></h3>
            </div>
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-purple d-flex justify-content-between align-items-center">
            <div>
                <small>Pending Bills</small>
                <h3><?php echo (int)$pendingBills; ?></h3>
            </div>
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Recent Appointments</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentAppointments)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-3">No appointments found.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($recentAppointments as $a): ?>
                        <tr>
                            <td><?php echo clean($a['patient_name']); ?></td>
                            <td><?php echo clean($a['doctor_name']); ?></td>
                            <td><?php echo clean($a['appointment_date']); ?></td>
                            <td><?php echo clean(date('h:i A', strtotime($a['appointment_time']))); ?></td>
                            <td><span class="badge badge-status-<?php echo clean($a['status']); ?>"><?php echo clean($a['status']); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-triangle-exclamation text-warning"></i> Low Stock Alert</div>
            <ul class="list-group list-group-flush">
                <?php if (empty($lowStock)): ?>
                    <li class="list-group-item text-muted">All inventory levels are healthy.</li>
                <?php endif; ?>
                <?php foreach ($lowStock as $item): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <?php echo clean($item['item_name']); ?>
                    <span class="badge bg-danger"><?php echo (int)$item['quantity']; ?> left</span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
