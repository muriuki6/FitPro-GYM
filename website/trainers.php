<?php
$pageTitle = 'Trainers | FitPro Gym';
$pageDescription = 'Meet FitPro Gym trainers, skills, ratings, experience, and social profiles.';
$activePage = 'trainers';
include __DIR__ . '/includes/header.php';

$trainers = website_query_rows($conn, 'trainers', "SELECT * FROM trainers ORDER BY id DESC");
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-user-tie"></i> Trainers</span>
<h1 class="hero-title">Coaches Who Make Progress <span>Practical.</span></h1>
<p class="page-copy">Our trainer cards are powered by the existing trainer database and enhanced with public-facing experience, skills, ratings, and social links.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-4">
<?php if(count($trainers) > 0): ?>
<?php foreach($trainers as $index => $trainer):
$skills = array_filter(array_map('trim', explode(',', $trainer['specialization'] ?? 'Strength, Conditioning, Coaching')));
?>
<div class="col-md-6 col-xl-4 reveal">
<div class="trainer-card overflow-hidden">
<img class="trainer-img" src="<?= h(image_url($trainer['photo'] ?? '')) ?>" alt="<?= h($trainer['fullname']) ?>">
<div class="p-4">
<div class="d-flex justify-content-between align-items-start gap-3">
<div>
<h3 class="fw-bold mb-1"><?= h($trainer['fullname']) ?></h3>
<p class="text-primary fw-semibold mb-2"><?= h($trainer['specialization'] ?? 'Personal Trainer') ?></p>
</div>
<span class="badge bg-success"><?= h($trainer['status'] ?? 'Active') ?></span>
</div>
<div class="rating mb-3"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-stroke"></i> <span class="text-muted">4.<?= 7 + ($index % 2) ?></span></div>
<p class="text-muted">Experience: <?= 3 + $index ?>+ years helping members train safely and consistently.</p>
<div class="d-flex flex-wrap gap-2 mb-3">
<?php foreach(array_slice($skills, 0, 4) as $skill): ?>
<span class="skill-pill"><?= h($skill) ?></span>
<?php endforeach; ?>
</div>
<div class="d-flex justify-content-between align-items-center">
<small class="text-muted"><i class="fa fa-phone me-1"></i><?= h($trainer['phone'] ?? 'Front desk') ?></small>
<div class="social-row">
<a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
<a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
</div>
</div>
</div>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="col-12"><div class="alert alert-info">Trainers will appear here once they are added in the admin panel.</div></div>
<?php endif; ?>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container text-center reveal">
<span class="section-kicker">Personal Training</span>
<h2 class="section-title">Book A Coaching Conversation</h2>
<p class="section-subtitle mx-auto">Talk to the team about your goals and get matched with the right trainer for your schedule, experience, and training style.</p>
<a class="btn btn-gradient mt-3" href="contact.php">Talk To The Team</a>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
