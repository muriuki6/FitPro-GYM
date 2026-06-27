<?php
$pageTitle = 'Join FitPro Gym';
$pageDescription = 'Create a FitPro member login account and start your membership journey.';
$activePage = '';
include __DIR__ . '/includes/header.php';

$message = '';
$messageType = 'info';

if(isset($_POST['register'])){
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = 3;

    if($fullname === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6){
        $message = 'Please enter your name, a valid email, and a password of at least 6 characters.';
        $messageType = 'danger';
    }else{
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param('s', $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $message = 'Email already exists. Please log in instead.';
            $messageType = 'warning';
        }else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (role_id,fullname,email,password,phone) VALUES (?,?,?,?,?)");
            $stmt->bind_param('issss', $role, $fullname, $email, $hash, $phone);
            $message = $stmt->execute() ? 'Registration successful. You can now log in.' : 'Registration failed. Please try again.';
            $messageType = $stmt->error ? 'danger' : 'success';
            $stmt->close();
        }
        $check->close();
    }
}
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-user-plus"></i> Join Now</span>
<h1 class="hero-title">Start Your FitPro <span>Journey.</span></h1>
<p class="page-copy">Create a member login. The front desk can link your account to your membership profile for portal access.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-6 reveal">
<div class="premium-card p-4">
<?php if($message): ?><div class="alert alert-<?= h($messageType) ?>"><?= h($message) ?></div><?php endif; ?>
<form method="post">
<label class="form-label">Full Name</label>
<input class="form-control mb-3" name="fullname" required>
<label class="form-label">Email</label>
<input class="form-control mb-3" type="email" name="email" required>
<label class="form-label">Phone</label>
<input class="form-control mb-3" name="phone">
<label class="form-label">Password</label>
<input class="form-control mb-3" type="password" name="password" minlength="6" required>
<button class="btn btn-gradient w-100" name="register" type="submit">Create Account</button>
</form>
<hr>
<a href="login.php">Already have an account?</a>
</div>
</div>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
