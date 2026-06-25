<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 2){
    header("Location: ../login.php");
    exit();
}

$totalMembers = $conn->query("
SELECT COUNT(*) total
FROM members
")->fetch_assoc()['total'];

$activeMembers = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE status='Active'
AND (expiry_date IS NULL OR expiry_date >= CURDATE())
")->fetch_assoc()['total'];

$todayAttendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE attendance_date=CURDATE()
AND status='Present'
")->fetch_assoc()['total'];

$weeklyAttendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE attendance_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()
AND status='Present'
")->fetch_assoc()['total'];

$expiringSoon = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
")->fetch_assoc()['total'];

$recentAttendance = $conn->query("
SELECT
a.*,
m.fullname
FROM attendance a
JOIN (
    SELECT MAX(id) id
    FROM attendance
    GROUP BY member_id, attendance_date
) latest
ON latest.id = a.id
JOIN members m
ON a.member_id = m.id
ORDER BY a.id DESC
LIMIT 8
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
<h3 class="mb-1">
<i class="fa fa-dumbbell"></i>
Trainer Dashboard
</h3>
<p class="mb-0 opacity-75">
Welcome back, <?= htmlspecialchars($_SESSION['fullname']) ?>. Track members and attendance from one place.
</p>
</div>
</div>

<div class="row mb-4">

<?php
$cards = [
    ['Total Members', number_format($totalMembers), 'fa-users', 'primary'],
    ['Active Members', number_format($activeMembers), 'fa-user-check', 'success'],
    ["Today's Attendance", number_format($todayAttendance), 'fa-calendar-check', 'info'],
    ['Weekly Attendance', number_format($weeklyAttendance), 'fa-chart-column', 'warning'],
    ['Expiring Soon', number_format($expiringSoon), 'fa-clock', 'danger'],
];

foreach($cards as $card):
?>

<div class="col-xl col-md-4 col-sm-6 mb-3">
<div class="card shadow border-<?= $card[3] ?> h-100">
<div class="card-body d-flex justify-content-between align-items-center">
<div>
<h6 class="text-muted mb-2"><?= $card[0] ?></h6>
<h4 class="mb-0"><?= $card[1] ?></h4>
</div>
<i class="fa <?= $card[2] ?> fa-2x text-<?= $card[3] ?>"></i>
</div>
</div>
</div>

<?php endforeach; ?>

</div>

<div class="row">

<div class="col-lg-4 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Quick Actions
</div>
<div class="card-body d-grid gap-2">
<a href="attendance.php" class="btn btn-success">
<i class="fa fa-calendar-check"></i>
Manage Attendance
</a>
<a href="members.php" class="btn btn-primary">
<i class="fa fa-users"></i>
View Members
</a>
<a href="profile.php" class="btn btn-info text-white">
<i class="fa fa-user-circle"></i>
View Profile
</a>
</div>
</div>
</div>

<div class="col-lg-8 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Recent Attendance
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle management-table">
<thead>
<tr>
<th>Member</th>
<th>Check In</th>
<th>Check Out</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>
<tbody>

<?php if($recentAttendance->num_rows > 0): ?>
<?php while($row = $recentAttendance->fetch_assoc()): ?>

<tr>
<td><?= htmlspecialchars($row['fullname']) ?></td>
<td><?= $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-' ?></td>
<td><?= $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
<td><?= date('d M Y', strtotime($row['attendance_date'])) ?></td>
<td>
<span class="badge <?= $row['status'] == 'Present' ? 'bg-success' : 'bg-warning text-dark' ?>">
<?= htmlspecialchars($row['status']) ?>
</span>
</td>
</tr>

<?php endwhile; ?>
<?php else: ?>

<tr>
<td colspan="5" class="text-center text-muted">
No attendance records found.
</td>
</tr>

<?php endif; ?>

</tbody>
</table>
</div>
</div>
</div>
</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>
