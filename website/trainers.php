<?php
$pageTitle = "Our Trainers | FitPro Gym";
$basePath = "";
include 'includes/website_header.php';
include 'includes/website_navbar.php';
include __DIR__ . '/../config/database.php';

$trainersQuery = $conn->query("
SELECT *
FROM trainers
WHERE status='Active'
ORDER BY fullname ASC
");
?>

<section class="hero" style="min-height:55vh">
<div class="hero-content" data-aos="fade-up">
<h1 class="display-4 fw-bold">Meet Our Expert Trainers</h1>
<p class="hero-subtitle">Certified coaches ready to support your fitness goals.</p>
</div>
</section>

<section class="py-5">
<div class="container-fluid px-4">
<div class="row align-items-end g-3 mb-4">
<div class="col-lg-6">
<h2 class="section-title text-start mb-2">Coaching Team</h2>
<p class="section-subtitle text-start">Loaded from the existing trainers table.</p>
</div>
<div class="col-lg-6">
<input type="search" class="form-control form-control-lg" id="trainerSearch" placeholder="Search trainers by name or specialization">
</div>
</div>

<div class="row g-4" id="trainersGrid">
<?php while($trainer = $trainersQuery->fetch_assoc()): ?>
<div class="col-lg-4 col-md-6 trainer-item" data-aos="fade-up" data-trainer="<?= htmlspecialchars(strtolower($trainer['fullname'].' '.$trainer['specialization'])) ?>">
<div class="trainer-card">
<?php if(!empty($trainer['photo'])): ?>
<img src="../assets/images/<?= htmlspecialchars($trainer['photo']) ?>" class="trainer-img" alt="<?= htmlspecialchars($trainer['fullname']) ?>">
<?php else: ?>
<div class="trainer-avatar"><i class="fa fa-user-tie"></i></div>
<?php endif; ?>
<div class="card-body">
<h5 class="trainer-name"><?= htmlspecialchars($trainer['fullname']) ?></h5>
<p class="trainer-specialty text-success fw-bold"><?= htmlspecialchars($trainer['specialization'] ?: 'Fitness Coach') ?></p>
<p class="mb-2"><i class="fa fa-briefcase text-primary me-2"></i>5+ years practical coaching experience</p>
<p class="mb-2"><i class="fa fa-dumbbell text-primary me-2"></i>Strength, conditioning, mobility, accountability</p>
<div class="mb-3">
<i class="fa fa-star text-warning"></i>
<i class="fa fa-star text-warning"></i>
<i class="fa fa-star text-warning"></i>
<i class="fa fa-star text-warning"></i>
<i class="fa fa-star-half-alt text-warning"></i>
<span class="text-muted small">(4.8 rating)</span>
</div>
<div class="social-links mb-3">
<a href="#"><i class="fab fa-instagram"></i></a>
<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-whatsapp"></i></a>
</div>
<a href="contact.php" class="btn btn-gradient w-100"><i class="fa fa-calendar me-2"></i>Book a Session</a>
</div>
</div>
</div>
<?php endwhile; ?>
</div>
</div>
</section>

<script>
document.getElementById('trainerSearch')?.addEventListener('input', function(){
    const value = this.value.toLowerCase();
    document.querySelectorAll('.trainer-item').forEach(item => {
        item.style.display = item.dataset.trainer.includes(value) ? '' : 'none';
    });
});
</script>

<?php include 'includes/website_footer.php'; ?>

