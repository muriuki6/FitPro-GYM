<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

/* Dashboard Statistics */

$totalMembers = $conn->query("
SELECT COUNT(*) total
FROM members
")->fetch_assoc()['total'];

$activeMembers = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE status='Active'
")->fetch_assoc()['total'];

$totalTrainers = $conn->query("
SELECT COUNT(*) total
FROM trainers
")->fetch_assoc()['total'];

$totalRevenue = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
")->fetch_assoc()['total'];

$monthlyRevenue = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
WHERE MONTH(payment_date)=MONTH(CURDATE())
AND YEAR(payment_date)=YEAR(CURDATE())
")->fetch_assoc()['total'];

$todayAttendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE attendance_date=CURDATE()
")->fetch_assoc()['total'];

$expiringMembers = $conn->query("
SELECT fullname, expiry_date
FROM members
WHERE expiry_date BETWEEN CURDATE()
AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
LIMIT 5
");











$activeMembers = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE expiry_date >= CURDATE()
")->fetch_assoc()['total'];

$expiredMembers = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE DATE(expiry_date) < CURDATE()
")->fetch_assoc()['total'];

$expiringSoon = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE DATE(expiry_date)
BETWEEN CURDATE()
AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
")->fetch_assoc()['total'];

/* ===============================
   FITNESS CLASSES STATISTICS
================================ */

$totalClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
")->fetch_assoc()['total'];

$activeClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
WHERE status='Active'
")->fetch_assoc()['total'];

$totalClassCapacity = $conn->query("
SELECT IFNULL(SUM(capacity),0) AS total
FROM classes
")->fetch_assoc()['total'];

$todayClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
WHERE DATE(schedule)=CURDATE()
")->fetch_assoc()['total'];


include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<!-- Welcome Banner -->

<div class="card bg-primary text-white shadow border-0 mb-4">

<div class="card-body">

<h2>
Welcome Back,
<?= htmlspecialchars($_SESSION['fullname']) ?>
</h2>

<p class="mb-0">
Manage members, attendance, trainers, payments and gym operations from one dashboard.
</p>

</div>

</div>

<!-- =========================
     Statistics Cards
========================= -->

<div class="row">

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 h-100">

            <div class="card-body">

                <i class="fa fa-users fa-2x mb-2 text-primary"></i>

                <h6>Total Members</h6>

                <h2><?= $totalMembers ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 h-100">

            <div class="card-body">

                <i class="fa fa-user-check fa-2x mb-2 text-success"></i>

                <h6>Active Members</h6>

                <h2><?= $activeMembers ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 h-100">

            <div class="card-body">

                <i class="fa fa-dumbbell fa-2x mb-2 text-warning"></i>

                <h6>Total Trainers</h6>

                <h2><?= $totalTrainers ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 h-100">

            <div class="card-body">

                <i class="fa fa-money-bill-wave fa-2x mb-2 text-success"></i>

                <h6>Total Revenue</h6>

                <h2>KES <?= number_format($totalRevenue) ?></h2>

            </div>

        </div>

    </div>

</div>

<!-- =========================
     Second Row
========================= -->

<div class="row">

    <div class="col-md-3 mb-3">

        <div class="card shadow border-success h-100">

            <div class="card-body">

                <i class="fa fa-chart-line fa-2x mb-2 text-success"></i>

                <h6>Monthly Revenue</h6>

                <h2>KES <?= number_format($monthlyRevenue) ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-primary h-100">

            <div class="card-body">

                <i class="fa fa-calendar-check fa-2x mb-2 text-primary"></i>

                <h6>Today's Attendance</h6>

                <h2><?= $todayAttendance ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-warning h-100">

            <div class="card-body">

                <i class="fa fa-clock fa-2x mb-2 text-warning"></i>

                <h6>Expiring Soon</h6>

                <h2><?= $expiringSoon ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-danger h-100">

            <div class="card-body">

                <i class="fa fa-exclamation-triangle fa-2x mb-2 text-danger"></i>

                <h6>Expired Members</h6>

                <h2><?= $expiredMembers ?></h2>

            </div>

        </div>

    </div>

</div>

<!-- =========================
     Third Row - Fitness Classes
========================= -->

<div class="row">

    <div class="col-md-3 mb-3">

        <div class="card shadow border-info h-100">

            <div class="card-body">

                <i class="fa fa-dumbbell fa-2x mb-2 text-info"></i>

                <h6>Total Classes</h6>

                <h2><?= $totalClasses ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-success h-100">

            <div class="card-body">

                <i class="fa fa-check-circle fa-2x mb-2 text-success"></i>

                <h6>Active Classes</h6>

                <h2><?= $activeClasses ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-primary h-100">

            <div class="card-body">

                <i class="fa fa-users fa-2x mb-2 text-primary"></i>

                <h6>Total Class Capacity</h6>

                <h2><?= $totalClassCapacity ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-warning h-100">

            <div class="card-body">

                <i class="fa fa-calendar-day fa-2x mb-2 text-warning"></i>

                <h6>Today's Classes</h6>

                <h2><?= $todayClasses ?></h2>

            </div>

        </div>

    </div>

</div>
<!-- Upcoming Expiry Notifications -->

<div class="card shadow mt-4 mb-4">

<div class="card-header bg-warning">

<h5 class="mb-0">

<i class="fa fa-bell"></i>

Upcoming Membership Expiries

</h5>

</div>

<div class="card-body">

<?php

$upcomingExpiries = $conn->query("
SELECT fullname, expiry_date
FROM members
WHERE expiry_date BETWEEN CURDATE()
AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
ORDER BY expiry_date ASC
LIMIT 5
");

?>

<?php if($upcomingExpiries->num_rows > 0): ?>

<table class="table table-hover">

<thead>

<tr>
<th>Member Name</th>
<th>Expiry Date</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php while($member = $upcomingExpiries->fetch_assoc()): ?>

<tr>

<td><?= htmlspecialchars($member['fullname']) ?></td>

<td><?= $member['expiry_date'] ?></td>

<td>

<span class="badge bg-warning text-dark">

Renew Soon

</span>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

<?php else: ?>

<div class="alert alert-success mb-0">

<i class="fa fa-check-circle"></i>

No memberships expiring within the next 7 days.

</div>

<?php endif; ?>

</div>

</div>
<!-- Quick Actions -->

<div class="card shadow mb-4">

<div class="card-body">

<h5 class="mb-3">Quick Actions</h5>

<a href="add_member.php" class="btn btn-primary">
<i class="fa fa-user-plus"></i> Add Member
</a>

<a href="add_trainer.php" class="btn btn-success">
<i class="fa fa-user-tie"></i> Add Trainer
</a>

<a href="payments.php" class="btn btn-warning">
<i class="fa fa-money-bill"></i> Record Payment
</a>

<a href="attendance.php" class="btn btn-info">
<i class="fa fa-calendar-check"></i> Attendance
</a>

</div>

</div>

<!-- Charts -->

<div class="row">

<div class="col-md-6">

<div class="card shadow">

<div class="card-body">

<h5>Revenue Chart</h5>

<canvas id="revenueChart"></canvas>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card shadow">

<div class="card-body">

<h5>Attendance Chart</h5>

<canvas id="attendanceChart"></canvas>

</div>

</div>

</div>

</div>

<!-- Recent Members -->

<div class="card shadow mt-4">

<div class="card-header">
Recent Members
</div>

<div class="card-body">

<table class="table table-striped">

<thead>

<tr>
<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php

$members = $conn->query("
SELECT *
FROM members
ORDER BY id DESC
LIMIT 5
");

while($row = $members->fetch_assoc()){

?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= htmlspecialchars($row['phone']) ?></td>

<td><?= htmlspecialchars($row['status']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<!-- Recent Payments -->

<div class="card shadow mt-4">

<div class="card-header">
Recent Payments
</div>

<div class="card-body">

<table class="table table-striped">

<thead>

<tr>
<th>Member</th>
<th>Amount</th>
<th>Date</th>
</tr>

</thead>

<tbody>

<?php

$payments = $conn->query("
SELECT
m.fullname,
p.amount,
p.payment_date
FROM payments p
JOIN members m
ON p.member_id=m.id
ORDER BY p.id DESC
LIMIT 5
");

while($pay = $payments->fetch_assoc()){

?>

<tr>

<td><?= htmlspecialchars($pay['fullname']) ?></td>

<td>
KES <?= number_format($pay['amount']) ?>
</td>

<td><?= $pay['payment_date'] ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<!-- Membership Expiry Alerts -->

<div class="card shadow mt-4">

<div class="card-header bg-danger text-white">

Upcoming Membership Expiry

</div>

<div class="card-body">

<table class="table table-striped">

<thead>

<tr>
<th>Name</th>
<th>Phone</th>
<th>Expiry Date</th>
</tr>

</thead>

<tbody>

<?php

$expiry = $conn->query("
SELECT fullname,phone,expiry_date
FROM members
WHERE expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
ORDER BY expiry_date ASC
");

while($row = $expiry->fetch_assoc()){

?>

<tr>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= htmlspecialchars($row['phone']) ?></td>

<td><?= $row['expiry_date'] ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
document.getElementById('revenueChart'),
{
type:'bar',
data:{
labels:['Jan','Feb','Mar','Apr','May','Jun'],
datasets:[{
label:'Revenue',
data:[12000,15000,18000,25000,22000,30000]
}]
}
});

new Chart(
document.getElementById('attendanceChart'),
{
type:'line',
data:{
labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
datasets:[{
label:'Attendance',
data:[15,20,18,25,30,28,35]
}]
}
});

</script>

<?php include '../includes/footer.php'; ?>