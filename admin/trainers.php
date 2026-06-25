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
FROM trainers
WHERE fullname LIKE ?
ORDER BY id DESC
");

$term = "%$search%";
$stmt->bind_param("s",$term);
$stmt->execute();

$trainers = $stmt->get_result();

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
<i class="fa fa-user-tie"></i>
Trainer Management
</h3>

<a href="add_trainer.php" class="btn btn-light text-primary fw-semibold">
<i class="fa fa-plus"></i>
Add Trainer
</a>

</div>
<div class="card-body">

<form method="GET">

<div class="input-group mb-3">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Trainer">

<button class="btn btn-primary">
Search
</button>

</div>

</form>

<div class="table-responsive">

<table class="table table-striped table-hover align-middle management-table">

<thead>

<tr>
<th>Photo</th>
<th>Name</th>
<th>Specialization</th>
<th>Phone</th>
<th>Status</th>
<th>Actions</th>
</tr>

</thead>

<tbody>

<?php while($row=$trainers->fetch_assoc()): ?>

<tr>


<td>

<?php if($row['photo']){ ?>

<img
src="../assets/images/<?= $row['photo'] ?>"
width="50">

<?php } ?>

</td>

<td><?= $row['fullname'] ?></td>

<td><?= $row['specialization'] ?></td>

<td><?= $row['phone'] ?></td>

<td><?= $row['status'] ?></td>

<td>

<a
href="edit_trainer.php?id=<?= $row['id'] ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<button
class="btn btn-danger btn-sm deleteTrainer"
data-id="<?= $row['id'] ?>">
Delete
</button>

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
document.querySelectorAll('.deleteTrainer').forEach(btn => {

    btn.addEventListener('click', function() {

        let id = this.dataset.id;

        if(confirm('Delete Trainer?')) {

            fetch('../api/delete_trainer.php?id=' + id)
            .then(response => response.text())
            .then(data => {

                console.log(data);
                alert(data);

                if(data.includes('Deleted')){
                    location.reload();
                }

            })
            .catch(error => {
                console.error(error);
                alert('Fetch Error');
            });

        }

    });

});
</script>

<?php include '../includes/footer.php'; ?>
