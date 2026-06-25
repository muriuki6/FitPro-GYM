<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 2){
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$userStmt = $conn->prepare("
SELECT *
FROM users
WHERE id=?
");
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();

$trainerStmt = $conn->prepare("
SELECT *
FROM trainers
WHERE email=?
OR fullname=?
LIMIT 1
");
$trainerStmt->bind_param("ss", $user['email'], $user['fullname']);
$trainerStmt->execute();
$trainer = $trainerStmt->get_result()->fetch_assoc();

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white">
<h3 class="mb-1">
<i class="fa fa-user-circle"></i>
Trainer Profile
</h3>
<p class="mb-0 opacity-75">
Your account and trainer record details.
</p>
</div>
</div>

<div class="row">

<div class="col-lg-4 mb-4">
<div class="card management-panel shadow h-100 text-center">
<div class="card-body">

<?php if(!empty($trainer['photo'])): ?>
<img
src="../assets/images/<?= htmlspecialchars($trainer['photo']) ?>"
class="profile-image mb-3"
alt="Trainer photo">
<?php else: ?>
<div class="trainer-avatar mx-auto mb-3">
<i class="fa fa-user-tie"></i>
</div>
<?php endif; ?>

<h4><?= htmlspecialchars($user['fullname']) ?></h4>
<p class="text-muted mb-2"><?= htmlspecialchars($user['email']) ?></p>
<span class="badge bg-primary">Trainer</span>

</div>
</div>
</div>

<div class="col-lg-8 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Profile Details
</div>
<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">
<label>Full Name</label>
<div class="form-control bg-light"><?= htmlspecialchars($user['fullname']) ?></div>
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<div class="form-control bg-light"><?= htmlspecialchars($user['email']) ?></div>
</div>

<div class="col-md-6 mb-3">
<label>Phone</label>
<div class="form-control bg-light"><?= htmlspecialchars($trainer['phone'] ?? $user['phone'] ?? '-') ?></div>
</div>

<div class="col-md-6 mb-3">
<label>Specialization</label>
<div class="form-control bg-light"><?= htmlspecialchars($trainer['specialization'] ?? 'Not assigned') ?></div>
</div>

<div class="col-md-6 mb-3">
<label>Status</label>
<div>
<span class="badge <?= (($trainer['status'] ?? $user['status']) == 'Active') ? 'bg-success' : 'bg-secondary' ?>">
<?= htmlspecialchars($trainer['status'] ?? $user['status']) ?>
</span>
</div>
</div>

<div class="col-md-6 mb-3">
<label>Trainer Code</label>
<div class="form-control bg-light"><?= htmlspecialchars($trainer['trainer_code'] ?? '-') ?></div>
</div>

</div>

</div>
</div>
</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>
