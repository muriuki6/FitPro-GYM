<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

include '../includes/member_context.php';

$daysLeft = member_days_left($memberProfile['expiry_date'] ?? null);
$planAmount = (float)($memberProfile['plan_amount'] ?? 0);
$amountPaid = (float)($memberProfile['amount_paid'] ?? 0);
$paymentPercent = $planAmount > 0 ? min(100, round(($amountPaid / $planAmount) * 100)) : 0;

include '../includes/header.php';
?>

<div class="d-flex">
<?php include '../includes/sidebar.php'; ?>
<div class="content flex-grow-1">
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white">
<h3 class="mb-1"><i class="fa fa-id-card"></i> My Membership</h3>
<p class="mb-0 opacity-75">Know your plan, renewal date, and payment position at a glance.</p>
</div>
</div>

<?php if(!$memberProfile): ?>
<div class="alert alert-warning shadow">No membership profile has been linked to your login yet.</div>
<?php else: ?>

<div class="row">
<div class="col-lg-5 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">Current Plan</div>
<div class="card-body">
<h3><?= htmlspecialchars($memberProfile['plan_name'] ?? 'No Plan') ?></h3>
<p class="text-muted"><?= htmlspecialchars($memberProfile['plan_description'] ?? 'Your active gym membership plan.') ?></p>
<div class="mb-3"><?= member_status_badge($memberProfile['status']) ?></div>
<div class="row">
<div class="col-6 mb-3">
<small class="text-muted">Join Date</small>
<h6><?= member_date($memberProfile['join_date']) ?></h6>
</div>
<div class="col-6 mb-3">
<small class="text-muted">Expiry Date</small>
<h6><?= member_date($memberProfile['expiry_date']) ?></h6>
</div>
<div class="col-6 mb-3">
<small class="text-muted">Days Left</small>
<h6><?= $daysLeft === null ? '-' : $daysLeft ?></h6>
</div>
<div class="col-6 mb-3">
<small class="text-muted">Duration</small>
<h6><?= htmlspecialchars($memberProfile['duration_days'] ?? '-') ?> Days</h6>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-7 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">Payment Health</div>
<div class="card-body">
<div class="d-flex justify-content-between mb-2">
<span>Plan payment completion</span>
<strong><?= $paymentPercent ?>%</strong>
</div>
<div class="progress member-progress mb-4">
<div class="progress-bar bg-success" style="width: <?= $paymentPercent ?>%"></div>
</div>
<div class="row text-center">
<div class="col-md-4 mb-3">
<div class="member-mini-card">
<small>Plan Cost</small>
<h5><?= member_money($memberProfile['plan_amount']) ?></h5>
</div>
</div>
<div class="col-md-4 mb-3">
<div class="member-mini-card">
<small>Amount Paid</small>
<h5><?= member_money($memberProfile['amount_paid']) ?></h5>
</div>
</div>
<div class="col-md-4 mb-3">
<div class="member-mini-card">
<small>Balance</small>
<h5><?= member_money($memberProfile['balance']) ?></h5>
</div>
</div>
</div>
<hr>
<h6>Plan Benefits</h6>
<p class="mb-0"><?= nl2br(htmlspecialchars($memberProfile['plan_benefits'] ?? 'Benefits will be updated by the gym team.')) ?></p>
</div>
</div>
</div>
</div>

<?php endif; ?>

</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>
