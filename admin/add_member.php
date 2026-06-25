<?php
include '../includes/auth.php';
include '../config/database.php';

$message = '';

if(isset($_POST['save']))
{
    $name = $_POST['fullname'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $plan = $_POST['plan_id'];

    $photo = '';

    if(!empty($_FILES['photo']['name']))
    {
        $photo = time().'_'.$_FILES['photo']['name'];

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            "../assets/images/".$photo
        );
    }

    /* Get Plan Details */

    $planData = $conn->prepare("
    SELECT *
    FROM membership_plans
    WHERE id = ?
    ");

    $planData->bind_param("i",$plan);
    $planData->execute();

    $planResult = $planData->get_result();
    $planRow = $planResult->fetch_assoc();

    $planAmount = $planRow['price'];

    /* Adjust this if your table uses a different column name */
    $durationDays = (int)$planRow['duration_days'];

    $stmt = $conn->prepare("
    INSERT INTO members
    (
        member_code,
        fullname,
        gender,
        phone,
        email,
        plan_id,
        plan_amount,
        amount_paid,
        balance,
        join_date,
        expiry_date,
        photo
    )
    VALUES
    (
        UUID(),
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        0,
        ?,
        CURDATE(),
        DATE_ADD(CURDATE(), INTERVAL ? DAY),
        ?
    )
    ");

    $stmt->bind_param(
        "ssssiddis",
        $name,
        $gender,
        $phone,
        $email,
        $plan,
        $planAmount,
        $planAmount,
        $durationDays,
        $photo
    );

    if($stmt->execute())
    {
        $message = "Member Added Successfully";
    }
    else
    {
        $message = "Error: ".$stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Member</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Add New Member</h3>
</div>

<div class="card-body">

<?php if($message): ?>
<div class="alert alert-info">
<?= $message ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">
<label>Full Name</label>
<input
type="text"
name="fullname"
class="form-control"
required>
</div>

<div class="col-md-6 mb-3">
<label>Gender</label>
<select
name="gender"
class="form-control">
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Phone</label>
<input
type="text"
name="phone"
class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input
type="email"
name="email"
class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Membership Plan</label>
<select
name="plan_id"
class="form-control"
required>

<option value="">
Select Plan
</option>

<?php

$plans = $conn->query("
SELECT *
FROM membership_plans
ORDER BY id ASC
");

while($p = $plans->fetch_assoc())
{
?>

<option value="<?= $p['id'] ?>">
<?= htmlspecialchars($p['plan_name']) ?>
 - KES <?= number_format($p['price'],2) ?>
</option>

<?php } ?>

</select>
</div>

<div class="col-md-6 mb-3">
<label>Photo</label>
<input
type="file"
name="photo"
class="form-control">
</div>

</div>

<button
type="submit"
name="save"
class="btn btn-success">

<i class="fa fa-save"></i>
Save Member

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