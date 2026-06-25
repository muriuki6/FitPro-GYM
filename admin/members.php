<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("
SELECT m.*, mp.plan_name
FROM members m
LEFT JOIN membership_plans mp ON m.plan_id = mp.id
WHERE fullname LIKE ?
ORDER BY m.id DESC
");

$searchTerm = "%$search%";
$stmt->bind_param("s",$searchTerm);
$stmt->execute();

$members = $stmt->get_result();

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">

<h3 class="mb-0">
<i class="fa fa-users"></i>
Members Management
</h3>

<a href="add_member.php" class="btn btn-light text-primary fw-semibold">
<i class="fa fa-user-plus"></i>
Add Member
</a>

</div>
<div class="card-body">

<form method="GET">

<div class="input-group mb-3">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Member"
value="<?= htmlspecialchars($search) ?>">

<button class="btn btn-primary">
Search
</button>

</div>

</form>

<div class="table-responsive">

<table class="table table-bordered table-striped table-hover align-middle management-table">

<thead>

<tr>
<th>Photo</th>
<th>Name</th>
<th>Phone</th>
<th>Membership</th>
<th>Status</th>
<th>Plan Cosst</th>
<th>Paid</th>
<th>Balance</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row=$members->fetch_assoc()): ?>

<tr>


<td>

<?php if($row['photo']){ ?>

<img
src="../assets/images/<?= $row['photo'] ?>"
width="50">

<?php } ?>

</td>

<td><?= $row['fullname'] ?></td>

<td><?= $row['phone'] ?></td>

<td><?= $row['plan_name'] ?></td>

<td><?= $row['status'] ?></td>




<td>
KES <?= number_format($row['plan_amount'],2) ?>
</td>

<td>
KES <?= number_format($row['amount_paid'],2) ?>
</td>

<td>

<?php

if($row['plan_amount'] <= 0){

echo '<span class="badge bg-secondary">No Plan Cost</span>';

}
elseif($row['balance'] > 0){

echo '<span class="badge bg-danger">KES '
    . number_format($row['balance'],2)
    . '</span>';

}
else{

echo '<span class="badge bg-success">Cleared</span>';

}

?>

</td>




<td>
<div class="d-flex gap-1 flex-nowrap">

<a
href="member_profile.php?id=<?= $row['id'] ?>"
class="btn btn-info btn-sm">
<i class="fa fa-user"></i> Profile
</a>

<a
href="edit_member.php?id=<?= $row['id'] ?>"
class="btn btn-warning btn-sm">
<i class="fa fa-edit"></i> Edit
</a>

<a
href="renew_membership.php?id=<?= $row['id'] ?>"
class="btn btn-success btn-sm">
<i class="fa fa-sync-alt"></i> Renew
</a>

<button
class="btn btn-danger btn-sm deleteBtn"
data-id="<?= $row['id'] ?>">
<i class="fa fa-trash"></i> Delete
</button>

</div>
</td>
</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

document.querySelectorAll('.deleteBtn')
.forEach(btn=>{

btn.addEventListener('click',function(){

if(confirm('Delete Member?')){

fetch('../api/delete_member.php?id='
+ this.dataset.id)

.then(res=>res.text())

.then(data=>{

alert(data);

location.reload();

});

}

});

});

</script>

<?php include '../includes/footer.php'; ?>
