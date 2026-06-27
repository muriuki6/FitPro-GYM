<?php
$pageTitle = 'Classes | FitPro Gym';
$pageDescription = 'View FitPro Gym weekly timetable, class search, filters, and trainer assignments.';
$activePage = 'classes';
include __DIR__ . '/includes/header.php';

$classes = table_exists($conn, 'classes')
    ? website_query_rows($conn, 'classes', "SELECT * FROM classes ORDER BY id DESC")
    : fallback_classes();
if(count($classes) === 0){
    $classes = fallback_classes();
}
$trainers = website_query_rows($conn, 'trainers', "SELECT fullname, specialization FROM trainers ORDER BY id DESC LIMIT 8");
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-calendar-days"></i> Classes</span>
<h1 class="hero-title">Find Your Next <span>Session.</span></h1>
<p class="page-copy">Search by class, filter by level, and check the weekly timetable before you train.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-3 mb-4 reveal">
<div class="col-lg-8"><input id="classSearch" class="form-control" placeholder="Search classes, trainers, categories..."></div>
<div class="col-lg-4">
<select id="classLevel" class="form-select">
<option value="all">All levels</option>
<option value="Beginner">Beginner</option>
<option value="Intermediate">Intermediate</option>
<option value="All Levels">All Levels</option>
</select>
</div>
</div>
<div class="row g-4">
<?php foreach($classes as $index => $class):
$name = $class['name'] ?? $class['class_name'] ?? 'FitPro Class';
$level = $class['level'] ?? ($index % 2 ? 'Intermediate' : 'All Levels');
$trainerName = $class['trainer'] ?? $class['trainer_name'] ?? ($trainers[$index % max(1, count($trainers))]['fullname'] ?? 'FitPro Coach');
?>
<div class="col-md-6 col-xl-3 reveal" data-class-card data-level="<?= h($level) ?>">
<div class="class-card p-4">
<span class="skill-pill mb-3"><?= h($class['category'] ?? 'Fitness') ?></span>
<h3 class="fw-bold"><?= h($name) ?></h3>
<p class="text-muted"><?= h($class['description'] ?? 'Coach-led training designed for safe, energetic progress.') ?></p>
<p class="mb-2"><i class="fa fa-clock text-primary me-2"></i><?= h($class['time'] ?? $class['schedule_time'] ?? $days[$index % count($days)] . ' 6:00 PM') ?></p>
<p class="mb-2"><i class="fa fa-user text-success me-2"></i><?= h($trainerName) ?></p>
<p class="mb-0"><i class="fa fa-signal text-primary me-2"></i><?= h($level) ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="text-center mb-5 reveal">
<span class="section-kicker">Weekly Timetable</span>
<h2 class="section-title">Plan Your Training Week</h2>
</div>
<div class="table-responsive reveal">
<table class="table table-modern table-bordered align-middle">
<thead><tr><th>Day</th><th>Morning</th><th>Evening</th><th>Coach</th></tr></thead>
<tbody>
<?php foreach($days as $index => $day): ?>
<tr>
<td class="fw-bold"><?= h($day) ?></td>
<td><?= h($classes[$index % count($classes)]['name'] ?? $classes[$index % count($classes)]['class_name'] ?? 'Strength Lab') ?> - 6:00 AM</td>
<td><?= h($classes[($index + 1) % count($classes)]['name'] ?? $classes[($index + 1) % count($classes)]['class_name'] ?? 'HIIT Burn') ?> - 6:30 PM</td>
<td><?= h($trainers[$index % max(1, count($trainers))]['fullname'] ?? 'FitPro Coach') ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
