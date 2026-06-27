<?php
$pageTitle = "Member Portal | FitPro Gym";
$basePath = "";
include 'includes/website_header.php';
include 'includes/website_navbar.php';
include __DIR__ . '/../config/database.php';

$features = [
    ['Profile','View your profile and contact information.','user-circle','../member/profile.php'],
    ['Membership Status','Track your plan, expiry date, and renewal status.','id-card','../member/membership.php'],
    ['Payment History','Review paid and pending payments.','wallet','../member/payments.php'],
    ['Receipts','Download receipts from recorded payments.','file-invoice','../member/payments.php'],
    ['Attendance','View check-ins, absences, and attendance trends.','calendar-check','../member/attendance.php'],
    ['Renew Membership','Request renewal support from your account.','rotate','../member/membership.php'],
];
?>
<section class="hero" style="min-height:55vh">
<div class="hero-content" data-aos="fade-up">
<h1 class="display-4 fw-bold">Member Portal</h1>
<p class="hero-subtitle">Everything members need after joining FitPro Gym.</p>
<a href="../login.php" class="btn btn-gradient btn-lg">Login to Portal</a>
</div>
</section>

<section class="py-5">
<div class="container-fluid px-4">
<div class="row g-4">
<?php foreach($features as $feature): ?>
<div class="col-lg-4 col-md-6" data-aos="fade-up">
<div class="feature">
<i class="fa fa-<?= $feature[2] ?> fa-3x text-success mb-3"></i>
<h4><?= htmlspecialchars($feature[0]) ?></h4>
<p><?= htmlspecialchars($feature[1]) ?></p>
<a href="<?= htmlspecialchars($feature[3]) ?>" class="btn btn-outline-success rounded-pill">Open</a>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<?php include 'includes/website_footer.php'; ?>


