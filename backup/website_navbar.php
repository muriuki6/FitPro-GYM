<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<div class="loading-screen" id="loadingScreen">
<div class="spinner"></div>
</div>

<nav class="navbar navbar-expand-lg fixed-top website-navbar">
<div class="container">
<a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
<img src="<?= $basePath ?>assets/images/favicon.svg" alt="FitPro Gym">
<span>FitPro Gym</span>
</a>
<button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#websiteMenu">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="websiteMenu">
<ul class="navbar-nav ms-auto align-items-lg-center">
<?php
$links = [
    'index.php' => 'Home',
    'about.php' => 'About',
    'membership.php' => 'Membership',
    'trainers.php' => 'Trainers',
    'classes.php' => 'Classes',
    'gallery.php' => 'Gallery',
    'contact.php' => 'Contact',
];
foreach($links as $href => $label):
?>
<li class="nav-item">
<a class="nav-link <?= $currentPage === $href ? 'active' : '' ?>" href="<?= $href ?>"><?= $label ?></a>
</li>
<?php endforeach; ?>
<li class="nav-item ms-lg-3 mt-3 mt-lg-0">
<button class="btn btn-glass" id="themeToggle" type="button"><i class="fa fa-moon"></i></button>
</li>
<li class="nav-item ms-lg-2 mt-3 mt-lg-0">
<a class="btn btn-gradient" href="../login.php">Member Login</a>
</li>
</ul>
</div>
</div>
</nav>

