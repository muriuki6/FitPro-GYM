<?php
http_response_code(404);
$pageTitle = "Page Not Found | FitPro Gym";
$basePath = "";
include 'includes/website_header.php';
include 'includes/website_navbar.php';
?>
<section class="hero" style="min-height:70vh">
<div class="hero-content" data-aos="fade-up">
<h1 class="display-1 fw-bold">404</h1>
<p class="hero-subtitle">The page you are looking for does not exist.</p>
<a href="index.php" class="btn btn-gradient btn-lg">Back Home</a>
</div>
</section>
<?php include 'includes/website_footer.php'; ?>


