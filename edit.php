<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_login();
$page_title = 'Edit Patient';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$id]);
$patient = $stmt->fetch();

if (!$patient) {
    set_flash('Patient not found.', 'error');
    redirect('list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name   = trim($_POST['full_name']);
    $gender      = $_POST['gender'];
    $dob         = $_POST['dob'] ?: null;
    $phone       = trim($_POST['phone']);
    $email       = trim($_POST['email']);
    $address     = trim($_POST['address']);
    $blood_group = trim($_POST['blood_group']);

    $stmt = $pdo->prepare("UPDATE patients SET full_name=?, gender=?, dob=?, phone=?, email=?, address=?, blood_group=? WHERE patient_id=?");
    $stmt->execute([$full_name, $gender, $dob, $phone, $email, $address, $blood_group, $id]);

    set_flash('Patient updated successfully.');
    redirect('list.php');
}

include __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fa-solid fa-pen"></i> Edit Patient</h3>
    <a href="list.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo clean($patient['full_name']); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select" required>
                        <?php foreach (['Male','Female','Other'] as $g): ?>
                            <option value="<?php echo $g; ?>" <?php echo $patient['gender'] === $g ? 'selected' : ''; ?>><?php echo $g; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="<?php echo clean($patient['dob']); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phone *</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo clean($patient['phone']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo clean($patient['email']); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Blood Group</label>
                    <select name="blood_group" class="form-select">
                        <option value="">Select</option>
                        <?php foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg): ?>
                            <option value="<?php echo $bg; ?>" <?php echo $patient['blood_group'] === $bg ? 'selected' : ''; ?>><?php echo $bg; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"><?php echo clean($patient['address']); ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4"><i class="fa-solid fa-floppy-disk"></i> Update Patient</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
