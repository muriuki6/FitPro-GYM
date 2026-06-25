<?php
include '../includes/auth.php';
include '../config/database.php';

$id = $_GET['id'];

$member = $conn->query("
SELECT *
FROM members
WHERE id=$id
")->fetch_assoc();

$message='';

if(isset($_POST['renew']))
{
    $plan = $_POST['plan_id'];

    $planData = $conn->query("
    SELECT *
    FROM membership_plans
    WHERE id=$plan
    ")->fetch_assoc();

    $price = $planData['price'];
    $days = $planData['duration_days'];

    $stmt = $conn->prepare("
    UPDATE members
    SET
    plan_id=?,
    plan_amount=?,
    amount_paid=0,
    balance=?,
    join_date=CURDATE(),
    expiry_date=
    DATE_ADD(CURDATE(),INTERVAL ? DAY)
    WHERE id=?
    ");

    $stmt->bind_param(
    "iddii",
    $plan,
    $price,
    $price,
    $days,
    $id
    );

    if($stmt->execute())
    {
        $message = "Membership Renewed Successfully";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Renew Membership</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
<h3>Renew Membership</h3>
</div>

<div class="card-body">

<?php if($message): ?>
<div class="alert alert-success">
<?= $message ?>
</div>
<?php endif; ?>

<h5><?= $member['fullname'] ?></h5>

<form method="POST">

<div class="mb-3">

<label>Select New Plan</label>

<select
name="plan_id"
class="form-control">

<?php

$plans = $conn->query("
SELECT *
FROM membership_plans
");

while($p = $plans->fetch_assoc())
{

?>

<option value="<?= $p['id'] ?>">
<?= $p['plan_name'] ?>
- KES <?= number_format($p['price']) ?>
</option>

<?php } ?>

</select>

</div>

<button
name="renew"
class="btn btn-success">

Renew Membership

</button>

<a
href="members.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

</body>
</html>