<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM patients WHERE patient_id = ?");
$stmt->execute([$id]);

set_flash('Patient deleted successfully.');
redirect('list.php');
