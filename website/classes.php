<?php
$pageTitle = "Fitness Classes | FitPro Gym";
$basePath = "";
include 'includes/website_header.php';
include 'includes/website_navbar.php';
include __DIR__ . '/../config/database.php';

$trainers = [];
$trainerResult = $conn->query("SELECT fullname FROM trainers WHERE status='Active' ORDER BY fullname ASC");
while($row = $trainerResult->fetch_assoc()){
    $trainers[] = $row['fullname'];
}

$classes = [
    ['Strength Lab','strength','Monday, Wednesday, Friday','6:00 PM',$trainers[0] ?? 'FitPro Coach','Progressive strength training with coaching on form and safe loading.','dumbbell'],
    ['HIIT Burn','cardio','Tuesday, Thursday','7:00 AM',$trainers[1] ?? 'FitPro Coach','High-energy intervals for conditioning, fat loss, and athletic performance.','fire'],
    ['Mobility Flow','wellness','Saturday','8:30 AM',$trainers[2] ?? 'FitPro Coach','Mobility, flexibility, and recovery work for better movement.','spa'],
    ['Box Fit','cardio','Friday','5:30 PM',$trainers[0] ?? 'FitPro Coach','Boxing-inspired conditioning with footwork, power, and endurance.','boxing-glove'],
    ['Core Control','strength','Sunday','9:00 AM',$trainers[1] ?? 'FitPro Coach','Core stability, posture, and full-body control training.','person-running'],
    ['Yoga Reset','wellness','Wednesday','6:30 AM',$trainers[2] ?? 'FitPro Coach','Calm, restorative movement for recovery and balance.','leaf'],
];
?>

<section class="hero" style="min-height:55vh">
<div class="hero-content" data-aos="fade-up">
<h1 class="display-4 fw-bold">Weekly Classes</h1>
<p class="hero-subtitle">Search, filter, and find the right session for your training week.</p>
</div>
</section>

<section class="py-5">
<div class="container-fluid px-4">
<div class="row align-items-end g-3 mb-4">
<div class="col-lg-5">
<h2 class="section-title text-start mb-2">Class Timetable</h2>
<p class="section-subtitle text-start">Trainer assignments use active trainers from your system.</p>
</div>
<div class="col-lg-4">
<input type="search" id="classSearch" class="form-control form-control-lg" placeholder="Search classes or trainers">
</div>
<div class="col-lg-3">
<div class="d-flex gap-2 flex-wrap justify-content-lg-end">
<?php foreach(['all'=>'All','strength'=>'Strength','cardio'=>'Cardio','wellness'=>'Wellness'] as $key=>$label): ?>
<button class="btn btn-outline-success filter-btn <?= $key==='all'?'active':'' ?>" data-filter="<?= $key ?>"><?= $label ?></button>
<?php endforeach; ?>
</div>
</div>
</div>

<div class="row g-4" id="classesGrid">
<?php foreach($classes as $class): ?>
<div class="col-lg-4 col-md-6 class-item" data-category="<?= htmlspecialchars($class[1]) ?>" data-search="<?= htmlspecialchars(strtolower(implode(' ', $class))) ?>" data-aos="fade-up">
<div class="class-card">
<div class="icon-box mb-4"><i class="fa fa-<?= htmlspecialchars($class[6]) ?>"></i></div>
<span class="badge badge-gradient mb-3"><?= htmlspecialchars(ucfirst($class[1])) ?></span>
<h4><?= htmlspecialchars($class[0]) ?></h4>
<p class="mb-2"><i class="fa fa-calendar text-success me-2"></i><?= htmlspecialchars($class[2]) ?></p>
<p class="mb-2"><i class="fa fa-clock text-success me-2"></i><?= htmlspecialchars($class[3]) ?></p>
<p class="mb-3"><i class="fa fa-user-tie text-success me-2"></i><?= htmlspecialchars($class[4]) ?></p>
<p><?= htmlspecialchars($class[5]) ?></p>
<a href="contact.php" class="btn btn-gradient w-100">Reserve Spot</a>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<script>
document.getElementById('classSearch')?.addEventListener('input', function(){
    const value = this.value.toLowerCase();
    document.querySelectorAll('.class-item').forEach(item => {
        item.style.display = item.dataset.search.includes(value) ? '' : 'none';
    });
});
</script>

<?php include 'includes/website_footer.php'; ?>

