<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

include '../includes/member_context.php';

include '../includes/header.php';
?>

<div class="d-flex">
<?php include '../includes/sidebar.php'; ?>
<div class="content flex-grow-1">
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white">
<h3 class="mb-1"><i class="fa fa-user-circle"></i> My Profile</h3>
<p class="mb-0 opacity-75">Your member identity, contact details, and emergency information.</p>
</div>
</div>

<div class="row">

<div class="col-lg-4 mb-4">
<div class="card management-panel shadow h-100 text-center">
<div class="card-body">
<?php if(!empty($memberProfile['photo'])): ?>
<img src="../assets/images/<?= htmlspecialchars($memberProfile['photo']) ?>" class="profile-image mb-3" alt="Member photo">
<?php else: ?>
<div class="member-avatar mx-auto mb-3"><i class="fa fa-user"></i></div>
<?php endif; ?>
<h4><?= htmlspecialchars($memberUser['fullname']) ?></h4>
<p class="text-muted mb-2"><?= htmlspecialchars($memberUser['email']) ?></p>
<?= member_status_badge($memberProfile['status'] ?? 'Pending') ?>
</div>
</div>
</div>

<div class="col-lg-8 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">Profile Details</div>
<div class="card-body">

<?php if(!$memberProfile): ?>
<div class="alert alert-warning mb-0">No linked member profile was found for this login.</div>
<?php else: ?>

<div class="row">
<div class="col-md-6 mb-3">
<label>Member Code</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['member_code'] ?? '-') ?></div>
</div>
<div class="col-md-6 mb-3">
<label>Full Name</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['fullname']) ?></div>
</div>
<div class="col-md-6 mb-3">
<label>Email</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['email']) ?></div>
</div>
<div class="col-md-6 mb-3">
<label>Phone</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['phone'] ?? '-') ?></div>
</div>
<div class="col-md-6 mb-3">
<label>Gender</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['gender'] ?? '-') ?></div>
</div>
<div class="col-md-6 mb-3">
<label>Emergency Contact</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['emergency_contact'] ?? '-') ?></div>
</div>
<div class="col-12 mb-3">
<label>Address</label>
<div class="form-control bg-light"><?= htmlspecialchars($memberProfile['address'] ?? '-') ?></div>
</div>
</div>

<?php endif; ?>

</div>
</div>
</div>

</div>

</div>

</div>
</div>

<?php include '../includes/footer.php'; ?>
