<?php
$pageTitle = 'Gallery | FitPro Gym';
$pageDescription = 'Explore FitPro Gym facilities, training zones, classes, and member moments in a responsive gallery.';
$activePage = 'gallery';
include __DIR__ . '/includes/header.php';

$items = [
    ['Gym aesthetic.jpg', 'facility', 'Strength Floor'],
    ['Defined Biceps & Physique - Blakspesh Fitness.jpg', 'training', 'Member Training'],
    ['Stronger Together.jpg', 'classes', 'Group Energy'],
    ['download(4).jpg', 'facility', 'Cardio Zone'],
    ['Personal Training Services in Chicago IL _ 360 Vitality Fitness.jpg', 'training', 'Performance Setup'],
    ['Some amazing shots of @wgberesfield 🙌__📸 @bigdogvisions_x.jpg', 'classes', 'Coached Session'],
    ['Personal Trainer.jpg', 'facility', 'Gym Interior'],
];
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-images"></i> Gallery</span>
<h1 class="hero-title">A Look Inside <span>FitPro.</span></h1>
<p class="page-copy">Browse facilities, training sessions, and class moments in a fast masonry gallery with lightbox previews.</p>
</div>
</section>

<section class="section-pad">
<div class="container" data-filter-group>
<div class="d-flex flex-wrap gap-2 justify-content-center mb-4 reveal">
<button class="filter-btn active" data-filter="all" type="button">All</button>
<button class="filter-btn" data-filter="facility" type="button">Facilities</button>
<button class="filter-btn" data-filter="training" type="button">Training</button>
<button class="filter-btn" data-filter="classes" type="button">Classes</button>
</div>
<div class="gallery-grid">
<?php foreach($items as $item): ?>
<article class="gallery-item reveal" data-category="<?= h($item[1]) ?>" data-lightbox="<?= h(image_url($item[0])) ?>">
<img class="gallery-img" src="<?= h(image_url($item[0])) ?>" alt="<?= h($item[2]) ?>">
<div class="gallery-caption">
<span class="skill-pill mb-2"><?= h(ucfirst($item[1])) ?></span>
<h5 class="fw-bold mb-0"><?= h($item[2]) ?></h5>
</div>
</article>
<?php endforeach; ?>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
