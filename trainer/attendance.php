<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 2){
    header("Location: ../login.php");
    exit();
}

$attendance = $conn->query("
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
LIMIT 50
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
<i class="fa fa-calendar-check"></i>
Attendance Management
</h3>
<p class="mb-0 opacity-75">
Check members in, check them out, or mark attendance for the day.
</p>
</div>
<div class="card-body">

<form id="attendanceForm">

<div class="row g-3 align-items-end">

<div class="col-lg-6">
<label>Member</label>
<select name="member_id" id="member_id" class="form-control" required>
<option value="">Select Member</option>

<?php
$members = $conn->query("
SELECT id, fullname
FROM members
WHERE status='Active'
ORDER BY fullname
");

while($member = $members->fetch_assoc()):
?>

<option value="<?= $member['id'] ?>">
<?= htmlspecialchars($member['fullname']) ?>
</option>

<?php endwhile; ?>

</select>
</div>

<div class="col-lg-2 col-md-4">
<button type="button" id="checkinBtn" class="btn btn-success w-100">
<i class="fa fa-right-to-bracket"></i>
Check In
</button>
</div>

<div class="col-lg-2 col-md-4">
<button type="button" id="checkoutBtn" class="btn btn-danger w-100">
<i class="fa fa-right-from-bracket"></i>
Check Out
</button>
</div>

<div class="col-lg-2 col-md-4">
<button type="button" id="absentBtn" class="btn btn-warning w-100">
<i class="fa fa-user-xmark"></i>
Absent
</button>
</div>

</div>

</form>

</div>
</div>

<div class="card management-panel shadow">
<div class="card-header bg-primary text-white">
Attendance History
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

<?php if($attendance->num_rows > 0): ?>
<?php while($row = $attendance->fetch_assoc()): ?>

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

<script>
function selectedMember(){
    const member = document.getElementById('member_id').value;

    if(member === ''){
        alert('Select Member');
        return null;
    }

    return member;
}

function submitAttendance(url, button){
    const member = selectedMember();

    if(!member){
        return;
    }

    button.disabled = true;

    fetch(url,{
        method:'POST',
        headers:{
            'Content-Type':'application/x-www-form-urlencoded'
        },
        body:'member_id=' + encodeURIComponent(member)
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(() => {
        button.disabled = false;
    });
}

document.getElementById('checkinBtn').addEventListener('click', function(){
    submitAttendance('../api/checkin.php', this);
});

document.getElementById('checkoutBtn').addEventListener('click', function(){
    submitAttendance('../api/checkout.php', this);
});

document.getElementById('absentBtn').addEventListener('click', function(){
    submitAttendance('../api/mark_absent.php', this);
});
</script>

<?php include '../includes/footer.php'; ?>
