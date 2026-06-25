<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 2){
    header("Location: ../login.php");
    exit();
}

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("
SELECT
m.*,
mp.plan_name
FROM members m
LEFT JOIN membership_plans mp
ON m.plan_id = mp.id
WHERE m.fullname LIKE ?
OR m.phone LIKE ?
OR m.email LIKE ?
ORDER BY m.fullname ASC
");

$term = "%$search%";
$stmt->bind_param("sss", $term, $term, $term);
$stmt->execute();
$members = $stmt->get_result();

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
<i class="fa fa-users"></i>
Member Directory
</h3>
<p class="mb-0 opacity-75">
View member contacts, plans, payment balance, and membership status.
</p>
</div>
<div class="card-body">

<form method="GET">
<div class="input-group mb-3">
<input
type="text"
name="search"
class="form-control"
placeholder="Search member by name, phone or email"
value="<?= htmlspecialchars($search) ?>">
<button class="btn btn-primary">
<i class="fa fa-search"></i>
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
<th>Email</th>
<th>Membership</th>
<th>Expiry</th>
<th>Balance</th>
<th>Status</th>
</tr>
</thead>
<tbody>

<?php if($members->num_rows > 0): ?>
<?php while($row = $members->fetch_assoc()): ?>

<tr>
<td>
<?php if(!empty($row['photo'])): ?>
<img src="../assets/images/<?= htmlspecialchars($row['photo']) ?>" alt="Member photo">
<?php else: ?>
<span class="badge bg-secondary">No Photo</span>
<?php endif; ?>
</td>
<td><?= htmlspecialchars($row['fullname']) ?></td>
<td><?= htmlspecialchars($row['phone']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['plan_name'] ?? 'No Plan') ?></td>
<td><?= $row['expiry_date'] ? date('d M Y', strtotime($row['expiry_date'])) : '-' ?></td>
<td>
<?php if((float)$row['balance'] > 0): ?>
<span class="badge bg-danger">KES <?= number_format($row['balance'], 2) ?></span>
<?php else: ?>
<span class="badge bg-success">Cleared</span>
<?php endif; ?>
</td>
<td>
<?php
$statusClass = 'bg-success';
if($row['status'] == 'Expired'){
    $statusClass = 'bg-danger';
}
elseif($row['status'] == 'Suspended'){
    $statusClass = 'bg-warning text-dark';
}
?>
<span class="badge <?= $statusClass ?>">
<?= htmlspecialchars($row['status']) ?>
</span>
</td>
</tr>

<?php endwhile; ?>
<?php else: ?>

<tr>
<td colspan="8" class="text-center text-muted">
No members found.
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

<?php include '../includes/footer.php'; ?>
