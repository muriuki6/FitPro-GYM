<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$message = '';

if(isset($_POST['login'])){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['fullname'] = $user['fullname'];

            if((int)$user['role_id'] === 1){
                header('Location: ../admin/dashboard.php');
            }elseif((int)$user['role_id'] === 2){
                header('Location: ../trainer/dashboard.php');
            }else{
                header('Location: member_dashboard.php');
            }
            exit();
        }
    }

    $message = 'Invalid login credentials.';
}

$pageTitle = 'Member Login | FitPro Gym';
$pageDescription = 'Log in to the FitPro Gym member portal.';
$activePage = '';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-right-to-bracket"></i> Member Login</span>
<h1 class="hero-title">Access Your <span>Portal.</span></h1>
<p class="page-copy">View membership status, payment history, receipts, attendance, and renewal options.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-5 reveal">
<div class="premium-card p-4">
<?php if($message): ?><div class="alert alert-danger"><?= h($message) ?></div><?php endif; ?>
<form method="post">
<label class="form-label">Email</label>
<input class="form-control mb-3" type="email" name="email" required>
<label class="form-label">Password</label>
<input class="form-control mb-3" type="password" name="password" required>
<button class="btn btn-gradient w-100" name="login" type="submit">Login</button>
</form>
<hr>
<a href="register.php">Create a member account</a>
</div>
</div>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
