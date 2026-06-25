<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

include '../includes/member_context.php';

$attendance = [];
$presentCount = 0;
$absentCount = 0;
$memberId = $memberProfile['id'] ?? 0;

if($memberId > 0){
    $stmt = $conn->prepare("
    SELECT a.*
    FROM attendance a
    JOIN (
        SELECT MAX(id) id
        FROM attendance
        WHERE member_id=?
        GROUP BY member_id, attendance_date
    ) latest
    ON latest.id = a.id
    ORDER BY a.attendance_date DESC, a.id DESC
    ");
    $stmt->bind_param("i", $memberId);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $attendance[] = $row;
        if($row['status'] == 'Present'){
            $presentCount++;
        }
        else{
            $absentCount++;
        }
    }
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
<h3 class="mb-1"><i class="fa fa-calendar-check"></i> My Attendance</h3>
<p class="mb-0 opacity-75">See your visits, missed sessions, and check-in records.</p>
</div>
</div>

<div class="row mb-4">
<div class="col-md-4 mb-3"><div class="card member-stat shadow h-100"><div class="card-body"><h6>Total Records</h6><h4><?= number_format(count($attendance)) ?></h4></div></div></div>
<div class="col-md-4 mb-3"><div class="card member-stat shadow h-100"><div class="card-body"><h6>Present</h6><h4><?= number_format($presentCount) ?></h4></div></div></div>
<div class="col-md-4 mb-3"><div class="card member-stat shadow h-100"><div class="card-body"><h6>Absent</h6><h4><?= number_format($absentCount) ?></h4></div></div></div>
</div>

<div class="card management-panel shadow">
<div class="card-header bg-primary text-white">Attendance History</div>
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
<?php if(count($attendance) > 0): ?>
<?php foreach($attendance as $row): ?>
<tr>
<td><?= member_date($row['attendance_date']) ?></td>
<td><?= $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-' ?></td>
<td><?= $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
<td><span class="badge <?= $row['status'] == 'Present' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= htmlspecialchars($row['status']) ?></span></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center text-muted">No attendance records found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>

</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>
