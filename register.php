<?php
include 'config/database.php';

$message = "";

if(isset($_POST['register']))
{
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $role = 3; // Member

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s",$email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0)
    {
        $message = "Email already exists.";
    }
    else
    {
        $stmt = $conn->prepare("
            INSERT INTO users
            (role_id,fullname,email,password,phone)
            VALUES(?,?,?,?,?)
        ");

        $stmt->bind_param(
            "issss",
            $role,
            $fullname,
            $email,
            $password,
            $phone
        );

        if($stmt->execute())
        {
            $message = "Registration successful.";
        }
        else
        {
            $message = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h4>Create Account</h4>
</div>

<div class="card-body">

<?php if($message!=""): ?>
<div class="alert alert-info">
<?= $message ?>
</div>
<?php endif; ?>

<form method="POST">

<input type="text"
name="fullname"
class="form-control mb-3"
placeholder="Full Name"
required>

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input type="text"
name="phone"
class="form-control mb-3"
placeholder="Phone">

<input type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="register"
class="btn btn-primary w-100">
Register
</button>

</form>

<hr>

<a href="login.php">
Already have an account?
Login
</a>

</div>
</div>
</div>
</div>
</div>

</body>
</html>