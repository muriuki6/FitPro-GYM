<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
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
JOIN members m ON a.member_id = m.id
ORDER BY a.id DESC
");

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h4>Attendance Management</h4>
</div>

<div class="card-body">

<form id="attendanceForm">



<div class="row">

<div class="col-md-6">
    <select name="member_id" id="member_id" class="form-control" required>
        <option value="">Select Member</option>

        <?php
        $members = $conn->query("
        SELECT id, fullname
        FROM members
        ORDER BY fullname
        ");

        while($member = $members->fetch_assoc()){
        ?>
            <option value="<?= $member['id'] ?>">
                <?= $member['fullname'] ?>
            </option>
        <?php } ?>

    </select>
</div>

<div class="col-md-2">
    <button
    type="button"
    id="checkinBtn"
    class="btn btn-success w-100">
        Check In
    </button>
</div>

<div class="col-md-2">
    <button
    type="button"
    id="checkoutBtn"
    class="btn btn-danger w-100">
        Check Out
    </button>
</div>

<div class="col-md-2">
    <button
    type="button"
    id="absentBtn"
    class="btn btn-warning w-100">
        Mark Absent
    </button>
</div>

</div>

</form>

<hr>

<h5>Attendance History</h5>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>Member</th>
<th>Check In</th>
<th>Check Out</th>
<th>Date</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php while($row = $attendance->fetch_assoc()): ?>

<tr>

<td><?= $row['fullname'] ?></td>
<td><?= $row['check_in'] ?></td>
<td><?= $row['check_out'] ?></td>
<td><?= $row['attendance_date'] ?></td>
<td><?= $row['status'] ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script>

document.getElementById('checkinBtn')
.addEventListener('click', function(){

let button = this;

let member =
document.getElementById('member_id').value;

if(member == ''){
alert('Select Member');
return;
}

button.disabled = true;

fetch('../api/checkin.php',{
method:'POST',
headers:{
'Content-Type':
'application/x-www-form-urlencoded'
},
body:'member_id='+member
})

.then(res=>res.text())
.then(data=>{
alert(data);
location.reload();
})
.catch(()=>{
button.disabled = false;
});

});

document.getElementById('checkoutBtn')
.addEventListener('click', function(){

let button = this;

let member =
document.getElementById('member_id').value;

if(member == ''){
alert('Select Member');
return;
}

button.disabled = true;

fetch('../api/checkout.php',{
method:'POST',
headers:{
'Content-Type':
'application/x-www-form-urlencoded'
},
body:'member_id='+member
})

.then(res=>res.text())
.then(data=>{
alert(data);
location.reload();
})
.catch(()=>{
button.disabled = false;
});

});

document.getElementById('absentBtn')
.addEventListener('click', function(){

let button = this;

let member =
document.getElementById('member_id').value;

if(member == ''){
alert('Select Member');
return;
}

button.disabled = true;

fetch('../api/mark_absent.php',{
method:'POST',
headers:{
'Content-Type':
'application/x-www-form-urlencoded'
},
body:'member_id='+member
})

.then(res=>res.text())
.then(data=>{
alert(data);
location.reload();
})
.catch(()=>{
button.disabled = false;
});

});

</script>

<?php include '../includes/footer.php'; ?>
