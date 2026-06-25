<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT * FROM membership_plans
WHERE id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Membership plan not found");
}

$plan = $result->fetch_assoc();

$message = '';

if(isset($_POST['update']))
{
    $plan_name = trim($_POST['plan_name']);
    $duration_days = intval($_POST['duration_days']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $benefits = trim($_POST['benefits']);

    $update = $conn->prepare("
    UPDATE membership_plans
    SET
        plan_name=?,
        duration_days=?,
        price=?,
        description=?,
        benefits=?
    WHERE id=?
    ");

    $update->bind_param(
        "sidssi",
        $plan_name,
        $duration_days,
        $price,
        $description,
        $benefits,
        $id
    );

    if($update->execute())
    {
        $message = "Membership Plan Updated";

        $stmt = $conn->prepare("
        SELECT *
        FROM membership_plans
        WHERE id=?
        ");

        $stmt->bind_param("i",$id);
        $stmt->execute();

        $plan = $stmt->get_result()->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Membership</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">
<h3>Edit Membership Plan</h3>
</div>

<div class="card-body">

<?php if($message): ?>

<div class="alert alert-success">
<?= $message ?>
</div>

<?php endif; ?>

<form method="POST">

<label>Plan Name</label>
<input
type="text"
name="plan_name"
class="form-control mb-3"
value="<?= htmlspecialchars($plan['plan_name']) ?>"
required>

<label>Duration (Days)</label>
<input
type="number"
name="duration_days"
class="form-control mb-3"
value="<?= $plan['duration_days'] ?>"
required>

<label>Price</label>
<input
type="number"
step="0.01"
name="price"
class="form-control mb-3"
value="<?= $plan['price'] ?>"
required>

<label>Description</label>
<textarea
name="description"
class="form-control mb-3"><?= htmlspecialchars($plan['description']) ?></textarea>

<label>Benefits</label>
<textarea
name="benefits"
class="form-control mb-3"><?= htmlspecialchars($plan['benefits']) ?></textarea>

<button
type="submit"
name="update"
class="btn btn-success">
Update Plan
</button>




<a
href="../api/delete_membership.php?id=<?= $plan['id'] ?>"
class="btn btn-danger"
onclick="return confirm('Are you sure you want to delete this membership plan?');">

<i class="fa fa-trash"></i>
Delete Plan

</a>




<a href="memberships.php"
class="btn btn-secondary">
Back
</a>

</form>

</div>

</div>

</div>

</body>
</html>