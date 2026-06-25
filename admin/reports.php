<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

function money($amount)
{
    return 'KES ' . number_format((float)$amount, 2);
}

function report_date($date)
{
    return date('d/m/Y', strtotime($date));
}

function fetch_all($result)
{
    $rows = [];

    while($row = $result->fetch_assoc()){
        $rows[] = $row;
    }

    return $rows;
}

$filter = $_GET['filter'] ?? 'this_month';
$allowedFilters = ['today','this_week','this_month','custom'];

if(!in_array($filter, $allowedFilters)){
    $filter = 'this_month';
}

$today = date('Y-m-d');
$startDate = $today;
$endDate = $today;

if($filter == 'this_week'){
    $startDate = date('Y-m-d', strtotime('monday this week'));
    $endDate = date('Y-m-d', strtotime('sunday this week'));
}
elseif($filter == 'this_month'){
    $startDate = date('Y-m-01');
    $endDate = date('Y-m-t');
}
elseif($filter == 'custom'){
    $customStart = $_GET['start_date'] ?? $today;
    $customEnd = $_GET['end_date'] ?? $today;

    $startDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $customStart)
        ? $customStart
        : $today;

    $endDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $customEnd)
        ? $customEnd
        : $today;

    if($startDate > $endDate){
        $tempDate = $startDate;
        $startDate = $endDate;
        $endDate = $tempDate;
    }
}

$totalRevenue = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
")->fetch_assoc()['total'];

$revenueThisMonth = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
WHERE MONTH(payment_date)=MONTH(CURDATE())
AND YEAR(payment_date)=YEAR(CURDATE())
")->fetch_assoc()['total'];

$revenueThisYear = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
WHERE YEAR(payment_date)=YEAR(CURDATE())
")->fetch_assoc()['total'];

$activeMembers = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE status='Active'
AND (expiry_date IS NULL OR expiry_date >= CURDATE())
")->fetch_assoc()['total'];

$expiredMembers = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE status='Expired'
OR DATE(expiry_date) < CURDATE()
")->fetch_assoc()['total'];

$pendingPayments = $conn->query("
SELECT COUNT(*) total
FROM payments
WHERE status='Pending'
")->fetch_assoc()['total'];

$membersWithBalances = $conn->query("
SELECT COUNT(*) total
FROM members
WHERE balance > 0
")->fetch_assoc()['total'];

$todayAttendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE attendance_date = CURDATE()
AND status='Present'
")->fetch_assoc()['total'];

$weeklyAttendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE attendance_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()
AND status='Present'
")->fetch_assoc()['total'];

$monthlyAttendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE MONTH(attendance_date)=MONTH(CURDATE())
AND YEAR(attendance_date)=YEAR(CURDATE())
AND status='Present'
")->fetch_assoc()['total'];

$revenueStmt = $conn->prepare("
SELECT
p.payment_date,
m.fullname,
p.amount
FROM payments p
JOIN members m
ON p.member_id = m.id
WHERE p.payment_date BETWEEN ? AND ?
ORDER BY p.payment_date DESC, p.id DESC
");

$revenueStmt->bind_param("ss", $startDate, $endDate);
$revenueStmt->execute();
$revenueRows = fetch_all($revenueStmt->get_result());
$revenueStmt->close();

$filteredRevenueTotal = 0;
foreach($revenueRows as $row){
    $filteredRevenueTotal += (float)$row['amount'];
}

$balances = fetch_all($conn->query("
SELECT
fullname,
plan_amount,
amount_paid,
balance
FROM members
ORDER BY balance DESC, fullname ASC
"));

$expiryRows = fetch_all($conn->query("
SELECT
fullname,
expiry_date,
DATEDIFF(expiry_date, CURDATE()) days_left
FROM members
WHERE expiry_date IS NOT NULL
ORDER BY expiry_date ASC, fullname ASC
"));

$attendanceChartRows = fetch_all($conn->query("
SELECT
attendance_date,
COUNT(*) total
FROM attendance
WHERE attendance_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()
AND status='Present'
GROUP BY attendance_date
ORDER BY attendance_date ASC
"));

$revenueChartRows = fetch_all($conn->query("
SELECT
payment_date,
IFNULL(SUM(amount),0) total
FROM payments
WHERE payment_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()
GROUP BY payment_date
ORDER BY payment_date ASC
"));

$attendanceMap = [];
foreach($attendanceChartRows as $row){
    $attendanceMap[$row['attendance_date']] = (int)$row['total'];
}

$revenueMap = [];
foreach($revenueChartRows as $row){
    $revenueMap[$row['payment_date']] = (float)$row['total'];
}

$chartLabels = [];
$attendanceChartData = [];
$revenueChartData = [];

for($i = 6; $i >= 0; $i--){
    $date = date('Y-m-d', strtotime("-$i days"));
    $chartLabels[] = date('d M', strtotime($date));
    $attendanceChartData[] = $attendanceMap[$date] ?? 0;
    $revenueChartData[] = $revenueMap[$date] ?? 0;
}

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
<i class="fa fa-chart-bar"></i>
Reports Dashboard
</h3>
<p class="mb-0 opacity-75">
Performance reports from <?= report_date($startDate) ?> to <?= report_date($endDate) ?>.
</p>
</div>
</div>

<div class="row mb-4">

<?php
$cards = [
    ['Total Revenue', money($totalRevenue), 'fa-money-bill-wave', 'success'],
    ['Revenue This Month', money($revenueThisMonth), 'fa-calendar-days', 'primary'],
    ['Revenue This Year', money($revenueThisYear), 'fa-chart-line', 'info'],
    ['Active Members', number_format($activeMembers), 'fa-users', 'success'],
    ['Expired Members', number_format($expiredMembers), 'fa-user-clock', 'danger'],
    ['Pending Payments', number_format($pendingPayments), 'fa-hourglass-half', 'warning'],
    ['Outstanding Balances', number_format($membersWithBalances), 'fa-scale-balanced', 'danger'],
    ["Today's Attendance", number_format($todayAttendance), 'fa-calendar-check', 'primary'],
];

foreach($cards as $card):
?>

<div class="col-xl-3 col-md-6 mb-3">
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

<div class="card shadow mb-4 management-panel">
<div class="card-header bg-primary text-white">
Revenue Reports
</div>
<div class="card-body">

<form method="GET" class="row g-3 align-items-end mb-4">

<div class="col-md-3">
<label>Filter</label>
<select name="filter" id="reportFilter" class="form-select">
<option value="today" <?= $filter == 'today' ? 'selected' : '' ?>>Today</option>
<option value="this_week" <?= $filter == 'this_week' ? 'selected' : '' ?>>This Week</option>
<option value="this_month" <?= $filter == 'this_month' ? 'selected' : '' ?>>This Month</option>
<option value="custom" <?= $filter == 'custom' ? 'selected' : '' ?>>Custom Date Range</option>
</select>
</div>

<div class="col-md-3 custom-date-field">
<label>Start Date</label>
<input
type="date"
name="start_date"
class="form-control"
value="<?= htmlspecialchars($startDate) ?>">
</div>

<div class="col-md-3 custom-date-field">
<label>End Date</label>
<input
type="date"
name="end_date"
class="form-control"
value="<?= htmlspecialchars($endDate) ?>">
</div>

<div class="col-md-3">
<button type="submit" class="btn btn-primary w-100">
<i class="fa fa-filter"></i>
Apply Filter
</button>
</div>

</form>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
<th>Date</th>
<th>Member</th>
<th class="text-end">Amount</th>
</tr>
</thead>
<tbody>

<?php if(count($revenueRows) > 0): ?>
<?php foreach($revenueRows as $row): ?>

<tr>
<td><?= report_date($row['payment_date']) ?></td>
<td><?= htmlspecialchars($row['fullname']) ?></td>
<td class="text-end"><?= number_format($row['amount'], 2) ?></td>
</tr>

<?php endforeach; ?>
<?php else: ?>

<tr>
<td colspan="3" class="text-center text-muted">
No revenue found for this period.
</td>
</tr>

<?php endif; ?>

</tbody>
<tfoot class="table-light">
<tr>
<th colspan="2" class="text-end">Total</th>
<th class="text-end"><?= money($filteredRevenueTotal) ?></th>
</tr>
</tfoot>
</table>
</div>

</div>
</div>

<div class="row">

<div class="col-lg-6 mb-4">
<div class="card shadow h-100 management-panel">
<div class="card-header bg-primary text-white">
Outstanding Balances Report
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
<th>Member</th>
<th class="text-end">Plan Cost</th>
<th class="text-end">Paid</th>
<th class="text-end">Balance</th>
<th>Status</th>
</tr>
</thead>
<tbody>

<?php foreach($balances as $row): ?>
<?php
$balance = (float)$row['balance'];
$badge = '<span class="badge bg-success">Cleared</span>';

if($balance > 10000){
    $badge = '<span class="badge bg-danger">High balance</span>';
}
elseif($balance > 0){
    $badge = '<span class="badge bg-warning text-dark">Small balance</span>';
}
?>

<tr>
<td><?= htmlspecialchars($row['fullname']) ?></td>
<td class="text-end"><?= number_format($row['plan_amount'], 2) ?></td>
<td class="text-end"><?= number_format($row['amount_paid'], 2) ?></td>
<td class="text-end"><?= number_format($row['balance'], 2) ?></td>
<td><?= $badge ?></td>
</tr>

<?php endforeach; ?>

</tbody>
</table>
</div>
</div>
</div>
</div>

<div class="col-lg-6 mb-4">
<div class="card shadow h-100 management-panel">
<div class="card-header bg-primary text-white">
Membership Expiry Report
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
<th>Member</th>
<th>Expiry Date</th>
<th>Days Left</th>
<th>Status</th>
</tr>
</thead>
<tbody>

<?php foreach($expiryRows as $row): ?>
<?php
$daysLeft = (int)$row['days_left'];
$expiryBadge = '<span class="badge bg-success">Active</span>';

if($daysLeft < 0){
    $expiryBadge = '<span class="badge bg-danger">Expired</span>';
}
elseif($daysLeft <= 7){
    $expiryBadge = '<span class="badge bg-warning text-dark">Expires soon</span>';
}
?>

<tr>
<td><?= htmlspecialchars($row['fullname']) ?></td>
<td><?= date('d-M-Y', strtotime($row['expiry_date'])) ?></td>
<td><?= $daysLeft ?></td>
<td><?= $expiryBadge ?></td>
</tr>

<?php endforeach; ?>

</tbody>
</table>
</div>
</div>
</div>
</div>

</div>

<div class="card shadow mb-4 management-panel">
<div class="card-header bg-primary text-white">
Attendance Analytics
</div>
<div class="card-body">

<div class="row mb-4">

<div class="col-md-4 mb-3">
<div class="border rounded p-3 h-100">
<h6 class="text-muted">Today's Attendance</h6>
<h3><?= number_format($todayAttendance) ?></h3>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="border rounded p-3 h-100">
<h6 class="text-muted">Weekly Attendance</h6>
<h3><?= number_format($weeklyAttendance) ?></h3>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="border rounded p-3 h-100">
<h6 class="text-muted">Monthly Attendance</h6>
<h3><?= number_format($monthlyAttendance) ?></h3>
</div>
</div>

</div>

<div class="row">

<div class="col-lg-6 mb-3">
<h6>Attendance Trend</h6>
<canvas id="attendanceReportChart" height="160"></canvas>
</div>

<div class="col-lg-6 mb-3">
<h6>Revenue Trend</h6>
<canvas id="revenueReportChart" height="160"></canvas>
</div>

</div>

</div>
</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const reportFilter = document.getElementById('reportFilter');
const customDateFields = document.querySelectorAll('.custom-date-field');

function toggleCustomDates(){
    const showCustomDates = reportFilter.value === 'custom';

    customDateFields.forEach(field => {
        field.style.display = showCustomDates ? '' : 'none';
    });
}

reportFilter.addEventListener('change', toggleCustomDates);
toggleCustomDates();

const labels = <?= json_encode($chartLabels) ?>;
const attendanceData = <?= json_encode($attendanceChartData) ?>;
const revenueData = <?= json_encode($revenueChartData) ?>;

new Chart(
    document.getElementById('attendanceReportChart'),
    {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Attendance',
                data: attendanceData,
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

new Chart(
    document.getElementById('revenueReportChart'),
    {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, .15)',
                fill: true,
                tension: .35
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }
);
</script>

<?php include '../includes/footer.php'; ?>
