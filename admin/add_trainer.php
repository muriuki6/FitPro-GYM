<?php
include '../includes/auth.php';
include '../config/database.php';

$message='';

if(isset($_POST['save']))
{
    $fullname=$_POST['fullname'];
    $specialization=$_POST['specialization'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $salary=$_POST['salary'];

    $photo='';

    if(!empty($_FILES['photo']['name']))
    {
        $photo=time().'_'.$_FILES['photo']['name'];

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            "../assets/images/".$photo
        );
    }

    $stmt=$conn->prepare("
    INSERT INTO trainers
    (
    trainer_code,
    fullname,
    specialization,
    phone,
    email,
    salary,
    photo
    )
    VALUES
    (
    UUID(),
    ?,?,?,?,?,?
    )
    ");

    $stmt->bind_param(
        "ssssss",
        $fullname,
        $specialization,
        $phone,
        $email,
        $salary,
        $photo
    );

    if($stmt->execute())
    {
        $message="Trainer Added Successfully";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Trainer</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Add Trainer</h2>

<?php if($message): ?>
<div class="alert alert-success">
<?= $message ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<input type="text"
name="fullname"
class="form-control mb-3"
placeholder="Full Name"
required>

<input type="text"
name="specialization"
class="form-control mb-3"
placeholder="Specialization">

<input type="text"
name="phone"
class="form-control mb-3"
placeholder="Phone">

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email">

<input type="number"
name="salary"
class="form-control mb-3"
placeholder="Salary">

<input type="file"
name="photo"
class="form-control mb-3">

<button
name="save"
class="btn btn-success">
Save Trainer
</button>

</form>

</div>

</body>
</html>