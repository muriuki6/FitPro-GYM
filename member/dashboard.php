<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

include '../includes/member_context.php';

$memberId = $memberProfile['id'] ?? 0;
$daysLeft = member_days_left($memberProfile['expiry_date'] ?? null);
$planAmount = (float)($memberProfile['plan_amount'] ?? 0);
$amountPaid = (float)($memberProfile['amount_paid'] ?? 0);
$balance = (float)($memberProfile['balance'] ?? 0);
$paymentPercent = $planAmount > 0 ? min(100, round(($amountPaid / $planAmount) * 100)) : 0;

$attendanceCount = 0;
$monthlyAttendance = 0;
$recentPayments = [];
$recentAttendance = [];
$attendanceChartData = array_fill(0, 7, 0);
$chartLabels = [];

for($i = 6; $i >= 0; $i--){
    $chartLabels[] = date('d M', strtotime("-$i days"));
}

if($memberId > 0){
    $attendanceCountStmt = $conn->prepare("
    SELECT COUNT(*) total
    FROM attendance
    WHERE member_id=?
    AND status='Present'
    ");
    $attendanceCountStmt->bind_param("i", $memberId);
    $attendanceCountStmt->execute();
    $attendanceCount = $attendanceCountStmt->get_result()->fetch_assoc()['total'];

    $monthlyAttendanceStmt = $conn->prepare("
    SELECT COUNT(*) total
    FROM attendance
    WHERE member_id=?
    AND status='Present'
    AND MONTH(attendance_date)=MONTH(CURDATE())
    AND YEAR(attendance_date)=YEAR(CURDATE())
    ");
    $monthlyAttendanceStmt->bind_param("i", $memberId);
    $monthlyAttendanceStmt->execute();
    $monthlyAttendance = $monthlyAttendanceStmt->get_result()->fetch_assoc()['total'];

    $paymentStmt = $conn->prepare("
    SELECT *
    FROM payments
    WHERE member_id=?
    ORDER BY id DESC
    LIMIT 5
    ");
    $paymentStmt->bind_param("i", $memberId);
    $paymentStmt->execute();
    $paymentResult = $paymentStmt->get_result();
    while($row = $paymentResult->fetch_assoc()){
        $recentPayments[] = $row;
    }

    $attendanceStmt = $conn->prepare("
    SELECT a.*
    FROM attendance a
    JOIN (
        SELECT MAX(id) id
        FROM attendance
        WHERE member_id=?
        GROUP BY member_id, attendance_date
    ) latest
    ON latest.id = a.id
    ORDER BY a.id DESC
    LIMIT 5
    ");
    $attendanceStmt->bind_param("i", $memberId);
    $attendanceStmt->execute();
    $attendanceResult = $attendanceStmt->get_result();
    while($row = $attendanceResult->fetch_assoc()){
        $recentAttendance[] = $row;
    }

    $chartStmt = $conn->prepare("
    SELECT attendance_date, COUNT(*) total
    FROM attendance
    WHERE member_id=?
    AND status='Present'
    AND attendance_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()
    GROUP BY attendance_date
    ");
    $chartStmt->bind_param("i", $memberId);
    $chartStmt->execute();
    $chartResult = $chartStmt->get_result();

    $attendanceMap = [];
    while($row = $chartResult->fetch_assoc()){
        $attendanceMap[$row['attendance_date']] = (int)$row['total'];
    }

    $attendanceChartData = [];
    for($i = 6; $i >= 0; $i--){
        $date = date('Y-m-d', strtotime("-$i days"));
        $attendanceChartData[] = $attendanceMap[$date] ?? 0;
    }
}

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card member-hero shadow mb-4">
<div class="card-body">
<div class="row align-items-center">
<div class="col-lg-8">
<span class="badge bg-light text-primary mb-3">Member Portal</span>
<h2 class="text-white mb-2">
Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>
</h2>
<p class="text-white-50 mb-0">
Track your membership, payments, attendance streak, and gym progress in one place.
</p>
</div>
<div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
<?= member_status_badge($memberProfile['status'] ?? 'Pending') ?>
<h5 class="text-white mt-3 mb-0">
<?= htmlspecialchars($memberProfile['plan_name'] ?? 'Membership not assigned') ?>
</h5>
<small class="text-white-50">
<?= $daysLeft === null ? 'No expiry date set' : ($daysLeft >= 0 ? $daysLeft . ' days left' : abs($daysLeft) . ' days expired') ?>
</small>
</div>
</div>
</div>
</div>

<?php if(!$memberProfile): ?>

<div class="alert alert-warning shadow">
Your login account is active, but no member profile is linked to your email yet. Please contact the admin desk.
</div>

<?php else: ?>

<div class="row mb-4">

<div class="col-xl-3 col-md-6 mb-3">
<div class="card member-stat shadow h-100">
<div class="card-body">
<i class="fa fa-id-card text-primary fa-2x mb-3"></i>
<h6>Membership</h6>
<h4><?= htmlspecialchars($memberProfile['plan_name'] ?? 'No Plan') ?></h4>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6 mb-3">
<div class="card member-stat shadow h-100">
<div class="card-body">
<i class="fa fa-calendar-days text-success fa-2x mb-3"></i>
<h6>Days Left</h6>
<h4><?= $daysLeft === null ? '-' : $daysLeft ?></h4>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6 mb-3">
<div class="card member-stat shadow h-100">
<div class="card-body">
<i class="fa fa-dumbbell text-warning fa-2x mb-3"></i>
<h6>This Month Visits</h6>
<h4><?= number_format($monthlyAttendance) ?></h4>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6 mb-3">
<div class="card member-stat shadow h-100">
<div class="card-body">
<i class="fa fa-wallet text-danger fa-2x mb-3"></i>
<h6>Balance</h6>
<h4><?= member_money($balance) ?></h4>
</div>
</div>
</div>

</div>

<div class="row">

<div class="col-lg-5 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Payment Progress
</div>
<div class="card-body">
<div class="d-flex justify-content-between mb-2">
<span>Paid</span>
<strong><?= $paymentPercent ?>%</strong>
</div>
<div class="progress member-progress mb-3">
<div class="progress-bar bg-success" style="width: <?= $paymentPercent ?>%"></div>
</div>
<div class="row text-center">
<div class="col">
<small class="text-muted">Plan Cost</small>
<h6><?= member_money($planAmount) ?></h6>
</div>
<div class="col">
<small class="text-muted">Paid</small>
<h6><?= member_money($amountPaid) ?></h6>
</div>
<div class="col">
<small class="text-muted">Balance</small>
<h6><?= member_money($balance) ?></h6>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-7 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Attendance Pulse
</div>
<div class="card-body">
<canvas id="memberAttendanceChart" height="130"></canvas>
</div>
</div>
</div>

</div>

<div class="row">

<div class="col-lg-6 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Recent Payments
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle management-table">
<thead>
<tr>
<th>Date</th>
<th>Amount</th>
<th>Method</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php if(count($recentPayments) > 0): ?>
<?php foreach($recentPayments as $payment): ?>
<tr>
<td><?= member_date($payment['payment_date']) ?></td>
<td><?= member_money($payment['amount']) ?></td>
<td><?= htmlspecialchars($payment['payment_method']) ?></td>
<td><span class="badge <?= $payment['status'] == 'Paid' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= htmlspecialchars($payment['status']) ?></span></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center text-muted">No payment records yet.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>

<div class="col-lg-6 mb-4">
<div class="card management-panel shadow h-100">
<div class="card-header bg-primary text-white">
Recent Attendance
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle management-table">
<thead>
<tr>
<th>Date</th>
<th>Check In</th>
<th>Check Out</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php if(count($recentAttendance) > 0): ?>
<?php foreach($recentAttendance as $row): ?>
<tr>
<td><?= member_date($row['attendance_date']) ?></td>
<td><?= $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-' ?></td>
<td><?= $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
<td><span class="badge <?= $row['status'] == 'Present' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= htmlspecialchars($row['status']) ?></span></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center text-muted">No attendance records yet.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>

</div>

<?php endif; ?>

</div>

</div>

</div>

<script>
new Chart(
    document.getElementById('memberAttendanceChart'),
    {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [{
                label: 'Visits',
                data: <?= json_encode($attendanceChartData) ?>,
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    }
);
</script>

<?php include '../includes/footer.php'; ?>
