<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT
m.*,
p.plan_name
FROM members m
LEFT JOIN membership_plans p
ON m.plan_id = p.id
WHERE m.id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Member not found");
}

$member = $result->fetch_assoc();

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>
<i class="fa fa-user-circle"></i>
Member Profile
</h2>

<a href="members.php" class="btn btn-secondary">
<i class="fa fa-arrow-left"></i>
Back
</a>

</div>

<!-- PROFILE CARD -->

<div class="card shadow border-0 mb-4">

<div class="card-body">

<div class="row align-items-center">

<div class="col-md-3 text-center">

<?php if(!empty($member['photo'])): ?>

<img
src="../assets/images/<?= $member['photo'] ?>"
class="img-fluid rounded-circle shadow"
style="width:180px;height:180px;object-fit:cover;">

<?php else: ?>

<img
src="https://via.placeholder.com/180"
class="img-fluid rounded-circle shadow">

<?php endif; ?>

</div>

<div class="col-md-9">

<h2 class="mb-3">
<?= htmlspecialchars($member['fullname']) ?>
</h2>

<div class="row">

<div class="col-md-6">

<p>
<strong>Member Code:</strong>
<?= $member['member_code'] ?>
</p>

<p>
<strong>Phone:</strong>
<?= htmlspecialchars($member['phone']) ?>
</p>

<p>
<strong>Email:</strong>
<?= htmlspecialchars($member['email']) ?>
</p>

<p>
<strong>Gender:</strong>
<?= $member['gender'] ?>
</p>

</div>

<div class="col-md-6">

<p>
<strong>Membership Plan:</strong>
<?= $member['plan_name'] ?>
</p>

<p>
<strong>Join Date:</strong>
<?= $member['join_date'] ?>
</p>

<p>
<strong>Expiry Date:</strong>
<?= $member['expiry_date'] ?>
</p>

<p>
<strong>Status:</strong>

<?php if($member['status']=='Active'): ?>

<span class="badge bg-success">
Active
</span>

<?php elseif($member['status']=='Expired'): ?>

<span class="badge bg-danger">
Expired
</span>

<?php else: ?>

<span class="badge bg-warning">
<?= $member['status'] ?>
</span>

<?php endif; ?>

</p>

</div>

</div>

</div>

</div>

</div>

</div>

<!-- PAYMENT SUMMARY -->

<div class="row mb-4">

<div class="col-md-4">

<div class="card shadow border-success">

<div class="card-body text-center">

<h6>Plan Cost</h6>

<h2>
KES <?= number_format($member['plan_amount'],2) ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-primary">

<div class="card-body text-center">

<h6>Total Paid</h6>

<h2>
KES <?= number_format($member['amount_paid'],2) ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-danger">

<div class="card-body text-center">

<h6>Balance</h6>

<h2>
KES <?= number_format($member['balance'],2) ?>
</h2>

</div>

</div>

</div>

</div>

<!-- PAYMENT HISTORY -->

<?php

$payments = $conn->query("
SELECT *
FROM payments
WHERE member_id = $id
ORDER BY id DESC
");

?>

<div class="card shadow border-0 mb-4">

<div class="card-header bg-dark text-white">

<h5 class="mb-0">
<i class="fa fa-money-bill-wave"></i>
Payment History
</h5>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>ID</th>
<th>Date</th>
<th>Amount</th>
<th>Method</th>
<th>Reference</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php while($payment = $payments->fetch_assoc()): ?>

<tr>

<td><?= $payment['id'] ?></td>

<td><?= $payment['payment_date'] ?></td>

<td>
KES <?= number_format($payment['amount'],2) ?>
</td>

<td><?= $payment['payment_method'] ?></td>

<td><?= $payment['reference_number'] ?></td>

<td>

<?php if($payment['status']=='Paid'): ?>

<span class="badge bg-success">
Paid
</span>

<?php elseif($payment['status']=='Pending'): ?>

<span class="badge bg-warning">
Pending
</span>

<?php else: ?>

<span class="badge bg-danger">
Failed
</span>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

<!-- ATTENDANCE HISTORY -->

<?php

$attendance = $conn->query("
SELECT *
FROM attendance
WHERE member_id = $id
ORDER BY attendance_date DESC
");

?>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">
<i class="fa fa-calendar-check"></i>
Attendance History
</h5>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Date</th>
<th>Status</th>
<th>Check In</th>
<th>Check Out</th>

</tr>

</thead>

<tbody>

<?php while($row = $attendance->fetch_assoc()): ?>

<tr>

<td><?= $row['attendance_date'] ?></td>

<td>

<?php if($row['status']=='Present'): ?>

<span class="badge bg-success">
Present
</span>

<?php else: ?>

<span class="badge bg-danger">
Absent
</span>

<?php endif; ?>

</td>

<td><?= $row['check_in'] ?></td>

<td><?= $row['check_out'] ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>