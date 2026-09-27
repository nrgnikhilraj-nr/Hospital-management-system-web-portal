<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_login();
$page_title = 'Invoice';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("
    SELECT b.*, p.full_name, p.phone, p.address
    FROM billing b JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?
");
$stmt->execute([$id]);
$bill = $stmt->fetch();

if (!$bill) {
    set_flash('Bill not found.', 'error');
    redirect('list.php');
}

include __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fa-solid fa-file-invoice"></i> Invoice #<?php echo (int)$bill['bill_id']; ?></h3>
    <div>
        <button onclick="window.print()" class="btn btn-outline-primary"><i class="fa-solid fa-print"></i> Print</button>
        <a href="list.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h4><i class="fa-solid fa-hospital"></i> MediCare HMS</h4>
                <p class="text-muted mb-0">Hospital Management System</p>
            </div>
            <div class="text-end">
                <p class="mb-0"><strong>Invoice Date:</strong> <?php echo clean(date('d M Y', strtotime($bill['billing_date']))); ?></p>
                <span class="badge badge-status-<?php echo clean($bill['payment_status']); ?>"><?php echo clean($bill['payment_status']); ?></span>
            </div>
        </div>
        <hr>
        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Billed To</h6>
                <p class="mb-0"><?php echo clean($bill['full_name']); ?></p>
                <p class="mb-0"><?php echo clean($bill['phone']); ?></p>
                <p class="mb-0"><?php echo clean($bill['address']); ?></p>
            </div>
        </div>
        <table class="table">
            <thead><tr><th>Description</th><th class="text-end">Amount</th></tr></thead>
            <tbody>
                <tr><td>Consultation Fee</td><td class="text-end">&#8377;<?php echo number_format($bill['consultation_fee'], 2); ?></td></tr>
                <tr><td>Medicine Charges</td><td class="text-end">&#8377;<?php echo number_format($bill['medicine_charges'], 2); ?></td></tr>
                <tr><td>Other Charges</td><td class="text-end">&#8377;<?php echo number_format($bill['other_charges'], 2); ?></td></tr>
            </tbody>
            <tfoot>
                <tr><th>Total</th><th class="text-end">&#8377;<?php echo number_format($bill['total_amount'], 2); ?></th></tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
