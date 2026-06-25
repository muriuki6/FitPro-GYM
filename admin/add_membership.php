<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$message = '';
$error = '';

if(isset($_POST['save']))
{
    $plan_name = trim($_POST['plan_name']);
    $duration_days = intval($_POST['duration_days']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $benefits = trim($_POST['benefits']);

    if(
        empty($plan_name) ||
        empty($duration_days) ||
        empty($price)
    )
    {
        $error = "Please fill all required fields.";
    }
    else
    {
        $stmt = $conn->prepare("
            INSERT INTO membership_plans
            (
                plan_name,
                duration_days,
                price,
                description,
                benefits
            )
            VALUES
            (
                ?, ?, ?, ?, ?
            )
        ");

        $stmt->bind_param(
            "sidss",
            $plan_name,
            $duration_days,
            $price,
            $description,
            $benefits
        );

        if($stmt->execute())
        {
            $message = "Membership Plan Added Successfully";
        }
        else
        {
            $error = "Failed to save membership plan.";
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

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>
<i class="fa fa-id-card"></i>
Add Membership Plan
</h3>

</div>

<div class="card-body">

<?php if($message): ?>

<div class="alert alert-success">
<?= $message ?>
</div>

<?php endif; ?>

<?php if($error): ?>

<div class="alert alert-danger">
<?= $error ?>
</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Plan Name
</label>

<input
type="text"
name="plan_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Duration (Days)
</label>

<input
type="number"
name="duration_days"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Price (KES)
</label>

<input
type="number"
step="0.01"
name="price"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea
name="description"
class="form-control"
rows="4"></textarea>

</div>

<div class="mb-3">

<label class="form-label">
Benefits
</label>

<textarea
name="benefits"
class="form-control"
rows="4"></textarea>

</div>

<button
type="submit"
name="save"
class="btn btn-success">

<i class="fa fa-save"></i>
 Save Plan

</button>

<a
href="memberships.php"
class="btn btn-secondary">

<i class="fa fa-arrow-left"></i>
 Back

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>