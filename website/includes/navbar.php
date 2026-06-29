<nav class="navbar navbar-expand-lg fixed-top site-nav">
<div class="container">
<a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
<img src="assets/images/FitPro%20Gym%20Logo.png" alt="FitPro Gym">
<span>FitProFitness</span>
</a>
<button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#siteMenu">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="siteMenu">
<ul class="navbar-nav ms-auto align-items-lg-center">
<?php
$links = [
    'home' => ['index.php','Home'],
    'about' => ['about.php','About'],
    'membership' => ['membership.php','Membership'],
    'trainers' => ['trainers.php','Trainers'],
    'classes' => ['classes.php','Classes'],
    'gallery' => ['gallery.php','Gallery'],
    'contact' => ['contact.php','Contact'],
];
foreach($links as $key => $link):
?>
<li class="nav-item">
<a class="nav-link <?= $activePage === $key ? 'active' : '' ?>" href="<?= $link[0] ?>"><?= $link[1] ?></a>
</li>
<?php endforeach; ?>
<li class="nav-item ms-lg-3 mt-3 mt-lg-0">
<button class="btn btn-glass" id="themeToggle" type="button" aria-label="Toggle dark mode">
<i class="fa fa-moon"></i>
</button>
</li>
<li class="nav-item ms-lg-2 mt-3 mt-lg-0">
<a href="login.php" class="btn btn-gradient">Member Login</a>
</li>
</ul>
</div>
</div>
</nav>
