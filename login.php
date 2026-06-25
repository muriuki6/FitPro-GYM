<?php

session_start();

include 'config/database.php';

$message = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE email=?
    ");

    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        $user = $result->fetch_assoc();

        if(password_verify(
            $password,
            $user['password']
        ))
        {
            $_SESSION['user_id'] =
            $user['id'];

            $_SESSION['role_id'] =
            $user['role_id'];

            $_SESSION['fullname'] =
            $user['fullname'];

            if($user['role_id']==1)
            {
                header("Location: admin/dashboard.php");
            }
            elseif($user['role_id']==2)
            {
                header("Location: trainer/dashboard.php");
            }
            else
            {
                header("Location: member/dashboard.php");
            }

            exit();
        }
    }

    $message = "Invalid Login Credentials";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>FitPro Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h4>FitPro Login</h4>
</div>

<div class="card-body">

<?php if($message!=""): ?>

<div class="alert alert-danger">
<?= $message ?>
</div>

<?php endif; ?>

<form method="POST">

<input
type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="login"
class="btn btn-primary w-100">
Login
</button>

</form>

<hr>

<a href="register.php">
Create Account
</a>

</div>
</div>

</div>
</div>

</div>

</body>
</html>