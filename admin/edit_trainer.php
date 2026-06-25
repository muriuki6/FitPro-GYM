<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM trainers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Trainer not found");
}

$trainer = $result->fetch_assoc();

$message = '';

if(isset($_POST['update']))
{
    $fullname = trim($_POST['fullname']);
    $specialization = trim($_POST['specialization']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $salary = $_POST['salary'];
    $status = $_POST['status'];

    $photo = $trainer['photo'];

    if(!empty($_FILES['photo']['name']))
    {
        $allowed = ['jpg','jpeg','png','gif','webp'];

        $extension = strtolower(
            pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)
        );

        if(in_array($extension, $allowed))
        {
            $newPhoto =
                time().'_'.uniqid().'.'.$extension;

            move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                "../assets/images/".$newPhoto
            );

            if(
                !empty($trainer['photo']) &&
                file_exists("../assets/images/".$trainer['photo'])
            )
            {
                unlink("../assets/images/".$trainer['photo']);
            }

            $photo = $newPhoto;
        }
    }

    $update = $conn->prepare("
        UPDATE trainers
        SET
            fullname=?,
            specialization=?,
            phone=?,
            email=?,
            salary=?,
            status=?,
            photo=?
        WHERE id=?
    ");

    $update->bind_param(
        "sssssssi",
        $fullname,
        $specialization,
        $phone,
        $email,
        $salary,
        $status,
        $photo,
        $id
    );

    if($update->execute())
    {
        $message = "Trainer updated successfully.";

        $stmt = $conn->prepare(
            "SELECT * FROM trainers WHERE id=?"
        );

        $stmt->bind_param("i",$id);
        $stmt->execute();

        $trainer = $stmt->get_result()->fetch_assoc();
    }
    else
    {
        $message = "Update failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Trainer</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-warning">
<h3 class="mb-0">
<i class="fa fa-user-edit"></i>
Edit Trainer
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
value="<?= htmlspecialchars($trainer['fullname']) ?>"
required>

<label class="form-label">
Specialization
</label>

<input
type="text"
name="specialization"
class="form-control mb-3"
value="<?= htmlspecialchars($trainer['specialization']) ?>">

<label class="form-label">
Phone
</label>

<input
type="text"
name="phone"
class="form-control mb-3"
value="<?= htmlspecialchars($trainer['phone']) ?>">

<label class="form-label">
Email
</label>

<input
type="email"
name="email"
class="form-control mb-3"
value="<?= htmlspecialchars($trainer['email']) ?>">

<label class="form-label">
Salary
</label>

<input
type="number"
step="0.01"
name="salary"
class="form-control mb-3"
value="<?= $trainer['salary'] ?>">

<label class="form-label">
Status
</label>

<select
name="status"
class="form-control mb-3">

<option value="Active"
<?= $trainer['status']=='Active' ? 'selected' : '' ?>>
Active
</option>

<option value="Inactive"
<?= $trainer['status']=='Inactive' ? 'selected' : '' ?>>
Inactive
</option>

</select>

<label class="form-label">
Current Photo
</label>

<div class="mb-3">

<?php if(!empty($trainer['photo'])): ?>

<img
src="../assets/images/<?= $trainer['photo'] ?>"
width="150"
class="img-thumbnail">

<?php else: ?>

<p class="text-muted">
No photo uploaded.
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
Update Trainer

</button>

<a
href="trainers.php"
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