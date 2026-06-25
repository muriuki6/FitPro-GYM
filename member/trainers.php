<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

$trainers = $conn->query("
SELECT *
FROM trainers
WHERE status='Active'
ORDER BY fullname ASC
");

include '../includes/header.php';
?>

<div class="d-flex">
<?php include '../includes/sidebar.php'; ?>
<div class="content flex-grow-1">
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white">
<h3 class="mb-1"><i class="fa fa-user-tie"></i> Gym Trainers</h3>
<p class="mb-0 opacity-75">Meet the coaches available to support your training goals.</p>
</div>
</div>

<div class="row">
<?php if($trainers->num_rows > 0): ?>
<?php while($trainer = $trainers->fetch_assoc()): ?>
<div class="col-xl-4 col-md-6 mb-4">
<div class="card member-trainer-card shadow h-100">
<div class="card-body text-center">
<?php if(!empty($trainer['photo'])): ?>
<img src="../assets/images/<?= htmlspecialchars($trainer['photo']) ?>" class="profile-image mb-3" alt="Trainer photo">
<?php else: ?>
<div class="trainer-avatar mx-auto mb-3"><i class="fa fa-user-tie"></i></div>
<?php endif; ?>
<h4><?= htmlspecialchars($trainer['fullname']) ?></h4>
<p class="text-primary fw-semibold"><?= htmlspecialchars($trainer['specialization'] ?? 'Fitness Coach') ?></p>
<p class="text-muted mb-1"><i class="fa fa-phone"></i> <?= htmlspecialchars($trainer['phone'] ?? '-') ?></p>
<p class="text-muted mb-0"><i class="fa fa-envelope"></i> <?= htmlspecialchars($trainer['email'] ?? '-') ?></p>
</div>
</div>
</div>
<?php endwhile; ?>
<?php else: ?>
<div class="col-12">
<div class="alert alert-info shadow">No active trainers are listed yet.</div>
</div>
<?php endif; ?>
</div>

</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>
