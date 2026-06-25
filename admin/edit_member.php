<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT *
FROM members
WHERE id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Member not found");
}

$member = $result->fetch_assoc();

$message = '';

if(isset($_POST['update']))
{
    $fullname = trim($_POST['fullname']);
    $gender = $_POST['gender'];
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $plan_id = $_POST['plan_id'];
    $expiry_date = $_POST['expiry_date'];

    // Auto determine status
    if($expiry_date < date('Y-m-d')){
        $status = 'Expired';
    }else{
        $status = 'Active';
    }

    $photo = $member['photo'];

    if(!empty($_FILES['photo']['name']))
    {
        $allowed = ['jpg','jpeg','png','gif','webp'];

        $extension = strtolower(
            pathinfo(
                $_FILES['photo']['name'],
                PATHINFO_EXTENSION
            )
        );

        if(in_array($extension,$allowed))
        {
            $newPhoto =
            time().'_'.uniqid().'.'.$extension;

            move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                "../assets/images/".$newPhoto
            );

            if(
                !empty($member['photo']) &&
                file_exists("../assets/images/".$member['photo'])
            )
            {
                unlink("../assets/images/".$member['photo']);
            }

            $photo = $newPhoto;
        }
    }

    $update = $conn->prepare("
    UPDATE members
    SET
        fullname=?,
        gender=?,
        phone=?,
        email=?,
        plan_id=?,
        status=?,
        expiry_date=?,
        photo=?
    WHERE id=?
    ");

    $update->bind_param(
        "ssssisssi",
        $fullname,
        $gender,
        $phone,
        $email,
        $plan_id,
        $status,
        $expiry_date,
        $photo,
        $id
    );

    if($update->execute())
    {
        $message = "Member Updated Successfully";

        $stmt = $conn->prepare("
        SELECT *
        FROM members
        WHERE id=?
        ");

        $stmt->bind_param("i",$id);
        $stmt->execute();

        $member =
        $stmt->get_result()->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Member</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>
<i class="fa fa-user-edit"></i>
Edit Member
</h3>

</div>

<div class="card-body">

<?php if($message): ?>

<div class="alert alert-success">
<?= $message ?>
</div>

<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<label class="form-label">
Full Name
</label>

<input
type="text"
name="fullname"
class="form-control mb-3"
value="<?= htmlspecialchars($member['fullname']) ?>"
required>

<label class="form-label">
Gender
</label>

<select
name="gender"
class="form-control mb-3">

<option value="Male"
<?= $member['gender']=='Male'?'selected':'' ?>>
Male
</option>

<option value="Female"
<?= $member['gender']=='Female'?'selected':'' ?>>
Female
</option>

</select>

<label class="form-label">
Phone
</label>

<input
type="text"
name="phone"
class="form-control mb-3"
value="<?= htmlspecialchars($member['phone']) ?>">

<label class="form-label">
Email
</label>

<input
type="email"
name="email"
class="form-control mb-3"
value="<?= htmlspecialchars($member['email']) ?>">

<label class="form-label">
Membership Plan
</label>

<select
name="plan_id"
class="form-control mb-3">

<?php

$plans = $conn->query("
SELECT *
FROM membership_plans
");

while($plan = $plans->fetch_assoc())
{
?>

<option
value="<?= $plan['id'] ?>"
<?= ($member['plan_id']==$plan['id']) ? 'selected' : '' ?>>

<?= $plan['plan_name'] ?>

</option>

<?php } ?>

</select>

<label class="form-label">
Expiry Date
</label>

<input
type="date"
name="expiry_date"
class="form-control mb-3"
value="<?= $member['expiry_date'] ?>"
required>

<label class="form-label">
Current Status
</label>

<input
type="text"
class="form-control mb-3"
value="<?= $member['status'] ?>"
readonly>

<label class="form-label">
Current Photo
</label>

<div class="mb-3">

<?php if(!empty($member['photo'])): ?>

<img
src="../assets/images/<?= $member['photo'] ?>"
width="150"
class="img-thumbnail">

<?php else: ?>

<p class="text-muted">
No Photo Uploaded
</p>

<?php endif; ?>

</div>

<label class="form-label">
Change Photo
</label>

<input
type="file"
name="photo"
class="form-control mb-4"
accept=".jpg,.jpeg,.png,.gif,.webp">

<button
type="submit"
name="update"
class="btn btn-success">

<i class="fa fa-save"></i>
Update Member

</button>

<a
href="members.php"
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

</body>
</html>