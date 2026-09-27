<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_login();
$page_title = 'Patients';

$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE full_name LIKE ? OR phone LIKE ? ORDER BY patient_id DESC");
    $like = "%$search%";
    $stmt->execute([$like, $like]);
} else {
    $stmt = $pdo->query("SELECT * FROM patients ORDER BY patient_id DESC");
}
$patients = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fa-solid fa-bed-pulse"></i> Patients</h3>
    <a href="add.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add Patient</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="<?php echo clean($search); ?>">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" type="submit"><i class="fa-solid fa-search"></i> Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>#</th><th>Name</th><th>Gender</th><th>DOB</th><th>Phone</th><th>Blood Group</th><th>Registered</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($patients)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No patients found.</td></tr>
                <?php endif; ?>
                <?php foreach ($patients as $p): ?>
                <tr>
                    <td><?php echo (int)$p['patient_id']; ?></td>
                    <td><?php echo clean($p['full_name']); ?></td>
                    <td><?php echo clean($p['gender']); ?></td>
                    <td><?php echo clean($p['dob']); ?></td>
                    <td><?php echo clean($p['phone']); ?></td>
                    <td><span class="badge bg-secondary"><?php echo clean($p['blood_group']); ?></span></td>
                    <td><?php echo clean(date('d M Y', strtotime($p['registered_on']))); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $p['patient_id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                        <a href="delete.php?id=<?php echo $p['patient_id']; ?>" class="btn btn-sm btn-outline-danger confirm-delete"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
