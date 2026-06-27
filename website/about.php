<?php
$pageTitle = 'About FitPro Gym | Our Story';
$pageDescription = 'Learn about FitPro Gym, our mission, facilities, certifications, and why members choose us.';
$activePage = 'about';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-circle-info"></i> About FitPro</span>
<h1 class="hero-title">A Smarter Gym For Serious <span>Progress.</span></h1>
<p class="page-copy">FitPro blends premium facilities, expert coaching, clean operations, and connected member tracking to make fitness easier to start and harder to quit.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-5 align-items-center">
<div class="col-lg-6 reveal">
<span class="section-kicker">Our Story</span>
<h2 class="section-title">Built For The Everyday Athlete</h2>
<p class="section-subtitle">FitPro Gym was created to give members a polished training environment with real guidance. From first-time beginners to experienced lifters, our focus is simple: clearer goals, safer training, better consistency.</p>
<p class="text-muted">The gym management system behind the scenes keeps memberships, payments, attendance, trainers, and renewals organized so the member experience feels smooth from the front desk to the training floor.</p>
</div>
<div class="col-lg-6 reveal">
<img class="w-100 rounded-3 shadow" src="<?= h(image_url('Triceps Pushdown for Sculpted Arms-Blakspesh fitness.jpg')) ?>" alt="FitPro gym equipment">
</div>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="row g-4">
<div class="col-lg-6 reveal">
<div class="premium-card p-4">
<div class="icon-tile mb-3"><i class="fa fa-bullseye"></i></div>
<h3 class="fw-bold">Mission</h3>
<p class="text-muted mb-0">Help members train consistently with expert coaching, clean facilities, flexible plans, and progress they can track.</p>
</div>
</div>
<div class="col-lg-6 reveal">
<div class="premium-card p-4">
<div class="icon-tile mb-3"><i class="fa fa-eye"></i></div>
<h3 class="fw-bold">Vision</h3>
<p class="text-muted mb-0">Become the most trusted fitness community for modern, measurable, and sustainable health transformation.</p>
</div>
</div>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="text-center mb-5 reveal">
<span class="section-kicker">Timeline</span>
<h2 class="section-title">How FitPro Keeps Evolving</h2>
</div>
<div class="timeline mx-auto" style="max-width:820px">
<?php
$timeline = [
    ['2023', 'FitPro opens with a commitment to personal coaching and clean facilities.'],
    ['2024', 'Expanded strength, cardio, and functional training zones.'],
    ['2025', 'Launched integrated member tracking for payments, attendance, and renewals.'],
    ['2026', 'Continued growth with public web booking paths, classes, and digital member tools.'],
];
foreach($timeline as $item):
?>
<div class="timeline-item reveal">
<h4 class="fw-bold"><?= h($item[0]) ?></h4>
<p class="text-muted"><?= h($item[1]) ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="row align-items-end mb-4">
<div class="col-lg-7 reveal">
<span class="section-kicker">Facilities</span>
<h2 class="section-title">Everything You Need To Train Well</h2>
</div>
</div>
<div class="row g-4">
<?php
$facilities = [
    ['fa-dumbbell', 'Strength Zone', 'Free weights, machines, racks, benches, and progressive training support.'],
    ['fa-heart-pulse', 'Cardio Deck', 'Treadmills, bikes, and endurance equipment for every fitness level.'],
    ['fa-people-group', 'Class Studio', 'Energetic group sessions for conditioning, mobility, and strength.'],
    ['fa-shower', 'Clean Amenities', 'Member-friendly changing areas and a clean, professional environment.'],
    ['fa-wifi', 'Digital Access', 'Integrated member portal for status, payments, receipts, and attendance.'],
    ['fa-user-shield', 'Safety First', 'Coach-led guidance and structured equipment zones.'],
];
foreach($facilities as $facility):
?>
<div class="col-md-6 col-lg-4 reveal">
<div class="premium-card p-4">
<div class="icon-tile mb-3"><i class="fa <?= h($facility[0]) ?>"></i></div>
<h4 class="fw-bold"><?= h($facility[1]) ?></h4>
<p class="text-muted mb-0"><?= h($facility[2]) ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-4">
<div class="col-lg-5 reveal">
<span class="section-kicker">Certifications</span>
<h2 class="section-title">Professional Standards</h2>
<p class="section-subtitle">Our team emphasizes safe programming, client care, and continuous learning.</p>
</div>
<div class="col-lg-7">
<div class="row g-3">
<?php foreach(['Certified Personal Training', 'First Aid Awareness', 'Strength & Conditioning', 'Nutrition Guidance'] as $cert): ?>
<div class="col-md-6 reveal"><div class="premium-card p-4"><i class="fa fa-certificate text-success me-2"></i><strong><?= h($cert) ?></strong></div></div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container text-center reveal">
<span class="section-kicker">Why Choose Us</span>
<h2 class="section-title">Premium Without The Friction</h2>
<p class="section-subtitle mx-auto">Clear memberships, trained staff, modern equipment, reliable attendance tracking, payment history, and a member portal that makes gym admin refreshingly simple.</p>
<a href="membership.php" class="btn btn-gradient mt-3">Choose Your Plan</a>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
