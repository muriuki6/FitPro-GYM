<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}


$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("
SELECT *
FROM membership_plans
WHERE plan_name LIKE ?
ORDER BY id DESC
");

$term = "%".$search."%";

$stmt->bind_param("s",$term);
$stmt->execute();

$plans = $stmt->get_result();

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">

<h3 class="mb-0">
<i class="fa fa-id-card"></i>
Membership Plans
</h3>

<a href="add_membership.php" class="btn btn-light text-primary fw-semibold">
    <i class="fa fa-plus"></i>
    Add Membership Plan
</a>

</div>
<div class="card-body">

<form method="GET">

<div class="input-group mb-4">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Membership Plan"
value="<?= htmlspecialchars($search) ?>">

<button class="btn btn-primary">
    <i class="fa fa-search"></i>
    Search
</button>

</div>

</form>

<div class="card shadow-sm management-panel">

<div class="card-body">

<table class="table table-bordered table-striped table-hover">

<thead class="table-dark">

<tr>
    <th>#</th>
    <th>Plan Name</th>
    <th>Duration</th>
    <th>Price</th>
    <th>Description</th>
    <th>Benefits</th>
    <th>Actions</th>
</tr>

</thead>

<tbody>

<?php $sn = 1; ?>

<?php if($plans->num_rows > 0): ?>

<?php while($row = $plans->fetch_assoc()): ?>

<tr>

<td><?= $sn++ ?></td>

<td><?= htmlspecialchars($row['plan_name']) ?></td>

<td>
<?=
isset($row['duration_days'])
? $row['duration_days'].' Days'
: (
isset($row['duration'])
? $row['duration'].' Days'
: 'N/A'
)
?>
</td>

<td>KES <?= number_format($row['price'],2) ?></td>

<td><?= htmlspecialchars($row['description']) ?></td>

<td><?= htmlspecialchars($row['benefits']) ?></td>

<td>

<a
href="edit_membership.php?id=<?= $row['id'] ?>"
class="btn btn-warning btn-sm">

<i class="fa fa-edit"></i>
Edit

</a>

<button
class="btn btn-danger btn-sm deletePlan"
data-id="<?= $row['id'] ?>">

<i class="fa fa-trash"></i>
Delete

</button>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>

<td colspan="7" class="text-center">
No Membership Plans Found
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

<script>

document.querySelectorAll('.deletePlan')
.forEach(button => {

button.addEventListener('click', function(){

let id = this.dataset.id;

if(confirm('Delete this membership plan?')){

fetch('../api/delete_membership.php?id=' + id)

.then(response => response.text())

.then(data => {

alert(data);

if(data.includes('Deleted'))
{
    location.reload();
}

})

.catch(error => {

console.error(error);

alert('Delete failed');

});

}

});

});

</script>

<?php include '../includes/footer.php'; ?>
