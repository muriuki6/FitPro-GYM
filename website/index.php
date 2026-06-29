<?php
$pageTitle = 'FitProFitness Gym | Premium Fitness Center';
$pageDescription = 'Join FitProFitness Gym for expert coaching, modern equipment, flexible memberships, classes, and a connected member portal.';
$activePage = 'home';
include __DIR__ . '/includes/header.php';

$totalMembers = website_count($conn, 'members');
$activeMembers = website_count($conn, 'members', "status='Active'");
$totalTrainers = website_count($conn, 'trainers');
$totalPlans = website_count($conn, 'membership_plans');
$totalAttendance = website_count($conn, 'attendance', "status='Present'");
$totalClasses = table_exists($conn, 'classes') ? website_count($conn, 'classes') : 12;

$plans = website_query_rows($conn, 'membership_plans', "SELECT * FROM membership_plans ORDER BY price ASC LIMIT 3");
$trainers = website_query_rows($conn, 'trainers', "SELECT * FROM trainers ORDER BY id DESC LIMIT 3");
$classes = table_exists($conn, 'classes')
    ? website_query_rows($conn, 'classes', "SELECT * FROM classes ORDER BY id DESC LIMIT 4")
    : fallback_classes();

$galleryImages = [
    'Defined Biceps & Physique - Blakspesh Fitness.jpg',
    'Gym aesthetic.jpg',
    'download(4).jpg',
    'Personal Training Services in Chicago IL _ 360 Vitality Fitness.jpg',
    'Stronger Together.jpg',
    'Some amazing shots of @wgberesfield 🙌__📸 @bigdogvisions_x.jpg',
];

$testimonials = [
    ['name' => 'Kevin M.', 'role' => 'Strength Member', 'quote' => 'FitPro gave me structure, accountability, and trainers who actually pay attention to progress.'],
    ['name' => 'Amina W.', 'role' => 'Group Class Member', 'quote' => 'The classes are polished, energetic, and welcoming. It feels premium without feeling intimidating.'],
    ['name' => 'Brian K.', 'role' => 'Member Portal User', 'quote' => 'I can track attendance, payments, and membership status without calling the desk every time.'],
];
?>

<section class="hero-section">
<div class="container position-relative">
<div class="row align-items-center g-5">
<div class="col-lg-7 reveal">
<span class="eyebrow"><i class="fa fa-bolt"></i> Premium Fitness Experience</span>
<h1 class="hero-title">Build Strength. Move Better. <span>Live Fit.</span></h1>
<p class="hero-copy">Train in a modern gym with certified coaches, flexible memberships, energetic classes, and a connected member portal that keeps your fitness journey visible.</p>
<div class="d-flex flex-wrap gap-3 mt-4">
<a href="membership.php" class="btn btn-gradient btn-lg">Join Now</a>
<a href="classes.php" class="btn btn-outline-light btn-lg rounded-pill px-4">Explore Classes</a>
</div>
</div>
<div class="col-lg-5 reveal">
<div class="hero-panel">
<div class="d-flex justify-content-between align-items-start mb-4">
<div>
<span class="eyebrow">Today at FitProFitness</span>
<h3 class="fw-bold mt-3 mb-1">Free fitness assessment</h3>
<p class="text-white-50 mb-0">Start with a trainer-led goal review and a practical workout path.</p>
</div>
<i class="fa fa-dumbbell fa-2x text-success"></i>
</div>
<div class="row g-3">
<div class="col-6"><div class="mini-metric"><i class="fa fa-users"></i><div><strong><?= number_format($activeMembers) ?></strong><br><small>Active members</small></div></div></div>
<div class="col-6"><div class="mini-metric"><i class="fa fa-user-tie"></i><div><strong><?= number_format($totalTrainers) ?></strong><br><small>Coaches</small></div></div></div>
<div class="col-6"><div class="mini-metric"><i class="fa fa-id-card"></i><div><strong><?= number_format($totalPlans) ?></strong><br><small>Plans</small></div></div></div>
<div class="col-6"><div class="mini-metric"><i class="fa fa-calendar-check"></i><div><strong><?= number_format($totalClasses) ?></strong><br><small>Classes</small></div></div></div>
</div>
</div>
</div>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="row g-4">
<?php
$stats = [
    ['Members', $totalMembers, 'fa-users'],
    ['Training Visits', $totalAttendance, 'fa-person-running'],
    ['Expert Trainers', $totalTrainers, 'fa-user-tie'],
    ['Membership Plans', $totalPlans, 'fa-award'],
];
foreach($stats as $stat):
?>
<div class="col-md-6 col-lg-3 reveal">
<div class="premium-card stat-card">
<div class="icon-tile mx-auto mb-3"><i class="fa <?= h($stat[2]) ?>"></i></div>
<h3><span data-count="<?= (int)$stat[1] ?>">0</span>+</h3>
<p class="text-muted mb-0"><?= h($stat[0]) ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="text-center mb-5 reveal">
<span class="section-kicker">Membership</span>
<h2 class="section-title">Flexible Plans For Real Progress</h2>
<p class="section-subtitle mx-auto">Plans are loaded from the existing membership system, keeping the website and admin dashboard aligned.</p>
</div>
<div class="row g-4">
<?php if(count($plans) > 0): ?>
<?php foreach($plans as $index => $plan): ?>
<div class="col-lg-4 reveal">
<div class="plan-card <?= $index === 1 ? 'featured' : '' ?>">
<?php if($index === 1): ?><span class="badge bg-primary mb-3">Most Popular</span><?php endif; ?>
<h3 class="fw-bold"><?= h($plan['plan_name']) ?></h3>
<p class="text-muted"><?= h(short_text($plan['description'] ?? 'A complete FitPro training plan.')) ?></p>
<div class="price mb-2"><?= money($plan['price']) ?></div>
<p class="text-muted"><?= (int)$plan['duration_days'] ?> days access</p>
<ul class="benefit-list mb-4">
<?php foreach(array_filter(preg_split('/\r\n|\r|\n|,/', $plan['benefits'] ?? 'Gym access,Trainer support,Member portal')) as $benefit): ?>
<li><i class="fa fa-check"></i><span><?= h(trim($benefit)) ?></span></li>
<?php endforeach; ?>
</ul>
<a href="register.php" class="btn btn-gradient w-100">Join Now</a>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="col-12"><div class="alert alert-info">Membership plans will appear here once they are added in the admin panel.</div></div>
<?php endif; ?>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="row align-items-end mb-4">
<div class="col-lg-8 reveal">
<span class="section-kicker">Coaching Team</span>
<h2 class="section-title">Featured Trainers</h2>
<p class="section-subtitle">Meet the coaches currently managed in the FitPro trainer database.</p>
</div>
<div class="col-lg-4 text-lg-end reveal"><a href="trainers.php" class="btn btn-outline-primary rounded-pill px-4">View All Trainers</a></div>
</div>
<div class="row g-4">
<?php if(count($trainers) > 0): ?>
<?php foreach($trainers as $trainer): ?>
<div class="col-md-6 col-lg-4 reveal">
<div class="trainer-card overflow-hidden">
<img class="trainer-img" src="<?= h(image_url($trainer['photo'] ?? '')) ?>" alt="<?= h($trainer['fullname']) ?>">
<div class="p-4">
<h4 class="fw-bold mb-1"><?= h($trainer['fullname']) ?></h4>
<p class="text-primary fw-semibold"><?= h($trainer['specialization'] ?? 'Personal Training') ?></p>
<div class="rating mb-3"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-stroke"></i> <span class="text-muted">4.8</span></div>
<a class="btn btn-sm btn-outline-primary rounded-pill" href="trainers.php">View Profile</a>
</div>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="col-12"><div class="alert alert-info">Featured trainers will appear after trainers are added in the management system.</div></div>
<?php endif; ?>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="text-center mb-5 reveal">
<span class="section-kicker">Classes</span>
<h2 class="section-title">Featured Fitness Classes</h2>
</div>
<div class="row g-4">
<?php foreach($classes as $class): ?>
<div class="col-md-6 col-lg-3 reveal">
<div class="class-card p-4">
<div class="icon-tile mb-3"><i class="fa fa-fire"></i></div>
<h4 class="fw-bold"><?= h($class['name'] ?? $class['class_name'] ?? 'FitPro Class') ?></h4>
<p class="text-muted"><?= h(short_text($class['description'] ?? 'A motivating, coach-led session.')) ?></p>
<span class="skill-pill"><i class="fa fa-clock"></i><?= h($class['time'] ?? $class['schedule_time'] ?? 'Weekly') ?></span>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="row g-4 align-items-center">
<div class="col-lg-6 reveal">
<span class="section-kicker">Members Say</span>
<h2 class="section-title">Proof In The Progress</h2>
<p class="section-subtitle">A premium gym experience is more than equipment. It is coaching, consistency, and a system that keeps members moving.</p>
</div>
<div class="col-lg-6 reveal">
<div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">
<?php foreach($testimonials as $index => $item): ?>
<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
<div class="testimonial-card p-4">
<div class="rating mb-3"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
<p class="fs-5">"<?= h($item['quote']) ?>"</p>
<h6 class="fw-bold mb-0"><?= h($item['name']) ?></h6>
<small class="text-muted"><?= h($item['role']) ?></small>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-4">
<div class="col-lg-7 reveal">
<span class="section-kicker">Gallery</span>
<h2 class="section-title">Inside FitPro</h2>
<div class="row g-3 mt-2">
<?php foreach(array_slice($galleryImages, 0, 4) as $image): ?>
<div class="col-6">
<button class="gallery-item border-0 p-0 w-100" data-lightbox="<?= h(image_url($image)) ?>">
<img class="gallery-img" src="<?= h(image_url($image)) ?>" alt="FitPro gym gallery">
</button>
</div>
<?php endforeach; ?>
</div>
</div>
<div class="col-lg-5 reveal">
  <div class="premium-card p-4 h-100">
    <span class="section-kicker">BMI Calculator</span>
    <h3 class="fw-bold mb-3">Check Your Starting Point</h3>
    
    <form id="bmiForm">
      <label class="form-label">Weight (kg)</label>
      <input id="bmiWeight" class="form-control mb-3" type="number" min="1" step="0.1" required>
      
      <label class="form-label">Height (cm)</label>
      <input id="bmiHeight" class="form-control mb-3" type="number" min="50" max="250" step="0.1" required>
      
      <button class="btn btn-gradient w-100" type="submit">Calculate BMI</button>
    </form>
    
    <!-- Result box -->
    <div id="bmiResult" class="premium-card p-3 mt-3 text-center">
      <span>Your result appears here</span>
    </div>
  </div>
</div>

<script>
document.getElementById("bmiForm").addEventListener("submit", function(event) {
  event.preventDefault(); // ✅ stops page reload

  const weight = parseFloat(document.getElementById("bmiWeight").value);
  const heightCm = parseFloat(document.getElementById("bmiHeight").value);

  if (!weight || !heightCm) return;

  // Convert cm → meters
  const heightM = heightCm / 100;

  // BMI formula
  const bmi = weight / (heightM * heightM);

  // Round to 1 decimal
  const bmiRounded = bmi.toFixed(1);

  // Determine category
  let category = "";
  if (bmi < 18.5) category = "Underweight";
  else if (bmi < 25) category = "Normal weight";
  else if (bmi < 30) category = "Overweight";
  else category = "Obese";

  // Display result inside the same card
  document.getElementById("bmiResult").innerHTML = 
    `<span>Your BMI is <strong>${bmiRounded}</strong> (${category})</span>`;
});
</script>

</section>

<section class="section-pad section-soft">
<div class="container">
<div class="row g-4 align-items-center">
<div class="col-lg-6 reveal">
<div class="premium-card p-4">
<span class="section-kicker">Newsletter</span>
<h3 class="fw-bold">Get training tips and membership offers</h3>
<form class="row g-2 mt-3" method="post" action="contact.php#newsletter">
<div class="col-md"><input class="form-control" type="email" name="newsletter_email" placeholder="Email address" required></div>
<div class="col-md-auto"><button class="btn btn-gradient w-100" name="subscribe" type="submit">Subscribe</button></div>
</form>
</div>
</div>
<div class="col-lg-6 reveal">
<div class="premium-card p-4">
<span class="section-kicker">Contact Preview</span>
<h3 class="fw-bold">Ready for a tour?</h3>
<p class="text-muted">Visit us Monday to Saturday, or message the team on WhatsApp for quick help.</p>
<a href="contact.php" class="btn btn-outline-primary rounded-pill px-4">Contact FitPro</a>
</div>
</div>
</div>
<div class="mt-5 reveal">
<iframe class="map-frame" loading="lazy" allowfullscreen src="https://www.google.com/maps?q=Nairobi%20Kenya&output=embed"></iframe>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
