<?php
$pageTitle = 'Membership Plans | FitPro Gym';
$pageDescription = 'Compare FitPro Gym membership plans loaded from the management database and join online.';
$activePage = 'membership';
include __DIR__ . '/includes/header.php';

$plans = website_query_rows($conn, 'membership_plans', "SELECT * FROM membership_plans ORDER BY price ASC");
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-id-card"></i> Membership</span>
<h1 class="hero-title">Choose The Plan That Fits <span>Your Pace.</span></h1>
<p class="page-copy">Every plan is connected to the existing FitPro management system so pricing, duration, and benefits stay current.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-4">
<?php if(count($plans) > 0): ?>
<?php foreach($plans as $index => $plan): ?>
<div class="col-md-6 col-xl-4 reveal">
<div class="plan-card <?= $index === 1 ? 'featured' : '' ?>">
<?php if($index === 1): ?><span class="badge bg-primary mb-3">Best Value</span><?php endif; ?>
<h3 class="fw-bold"><?= h($plan['plan_name']) ?></h3>
<div class="price"><?= money($plan['price']) ?></div>
<p class="text-muted"><?= (int)$plan['duration_days'] ?> days membership</p>
<p class="text-muted"><?= h($plan['description'] ?? 'FitPro membership plan') ?></p>
<ul class="benefit-list mb-4">
<?php foreach(array_filter(preg_split('/\r\n|\r|\n|,/', $plan['benefits'] ?? 'Gym access,Trainer guidance,Member portal')) as $benefit): ?>
<li><i class="fa fa-check"></i><span><?= h(trim($benefit)) ?></span></li>
<?php endforeach; ?>
</ul>
<a href="register.php" class="btn btn-gradient w-100">Join Now</a>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="col-12"><div class="alert alert-info">No membership plans have been added yet.</div></div>
<?php endif; ?>
</div>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<div class="text-center mb-5 reveal">
<span class="section-kicker">Compare</span>
<h2 class="section-title">Plan Comparison</h2>
</div>
<div class="table-responsive reveal">
<table class="table table-modern table-bordered align-middle">
<thead><tr><th>Plan</th><th>Duration</th><th>Price</th><th>Benefits</th><th></th></tr></thead>
<tbody>
<?php foreach($plans as $plan): ?>
<tr>
<td class="fw-bold"><?= h($plan['plan_name']) ?></td>
<td><?= (int)$plan['duration_days'] ?> days</td>
<td><?= money($plan['price']) ?></td>
<td><?= h(short_text($plan['benefits'] ?? 'Gym access', 90)) ?></td>
<td><a class="btn btn-sm btn-gradient" href="register.php">Join</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="row g-4">
<div class="col-lg-5 reveal">
<span class="section-kicker">FAQ</span>
<h2 class="section-title">Membership Questions</h2>
</div>
<div class="col-lg-7 reveal">
<div class="accordion" id="membershipFaq">
<?php
$faqs = [
    ['Can I renew my membership online?', 'Members can log in to the portal to review status and use renewal links that connect back to the gym team.'],
    ['Do plans include trainer support?', 'Plan benefits are managed by the admin team and displayed live here. Many plans include trainer guidance.'],
    ['Can I download receipts?', 'Yes. Logged-in members can view payment history and open printable receipts from the portal.'],
];
foreach($faqs as $index => $faq):
?>
<div class="accordion-item">
<h2 class="accordion-header"><button class="accordion-button <?= $index ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $index ?>"><?= h($faq[0]) ?></button></h2>
<div id="faq<?= $index ?>" class="accordion-collapse collapse <?= !$index ? 'show' : '' ?>" data-bs-parent="#membershipFaq"><div class="accordion-body"><?= h($faq[1]) ?></div></div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
