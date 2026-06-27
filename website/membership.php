<?php
/**
 * FitPro Gym - Membership Page
 * Dynamic membership plans with comparison and CTA
 */

$pageTitle = "Membership Plans | FitPro Gym";
$basePath = "";

include 'includes/website_header.php';
include 'includes/website_navbar.php';
include __DIR__ . '/../config/database.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 50vh;">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-4 fw-bold">Membership Plans</h1>
        <p class="hero-subtitle">Find the perfect plan for your fitness goals</p>
    </div>
</section>

<!-- Pricing Plans Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Our Membership Plans</h2>
            <p class="section-subtitle">
                Flexible plans designed to fit your lifestyle and budget
            </p>
        </div>
        
        <div class="row g-4">
            <?php
            $plansQuery = $conn->query("SELECT * FROM membership_plans ORDER BY price ASC");
            $planIndex = 0;
            
            while ($plan = $plansQuery->fetch_assoc()):
                $isPopular = ($plan['plan_name'] == 'Premium' || $plan['plan_name'] == 'Pro');
                $delay = $planIndex * 100;
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="membership-card <?php echo $isPopular ? 'featured' : ''; ?>">
                    <?php if ($isPopular): ?>
                        <span class="badge badge-gradient">Most Popular</span>
                    <?php endif; ?>
                    
                    <h3 class="h4 mb-2"><?php echo htmlspecialchars($plan['plan_name']); ?></h3>
                    <div class="plan-price">
                        KES <?php echo number_format($plan['price'], 0); ?>
                        <span class="text-muted fs-6">/month</span>
                    </div>
                    
                    <p class="text-muted small mb-3">
                        <?php echo htmlspecialchars($plan['description']); ?>
                    </p>
                    
                    <ul class="plan-features">
                        <li>24/7 Gym Access</li>
                        <li>All Equipment Access</li>
                        <li>Group Classes</li>
                        <li>Mobile App Access</li>
                        <li>Member Community</li>
                        <?php if (strpos($plan['plan_name'], 'Premium') !== false || strpos($plan['plan_name'], 'Pro') !== false): ?>
                            <li>Personal Training (4 sessions)</li>
                            <li>Nutrition Consultation</li>
                            <li>Progress Tracking</li>
                            <li>Priority Support</li>
                        <?php endif; ?>
                        <?php if (strpos($plan['plan_name'], 'Elite') !== false): ?>
                            <li>Unlimited Personal Training</li>
                            <li>VIP Services</li>
                        <?php endif; ?>
                    </ul>
                    
                    <button class="btn btn-gradient w-100" data-bs-toggle="modal" data-bs-target="#joinModal" onclick="setPlan('<?php echo htmlspecialchars($plan['plan_name']); ?>', <?php echo $plan['price']; ?>)">
                        Join Now
                    </button>
                </div>
            </div>
            <?php
                $planIndex++;
            endwhile;
            ?>
        </div>
    </div>
</section>

<!-- Plan Comparison Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Plan Comparison</h2>
        
        <div class="table-responsive" data-aos="fade-up">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Features</th>
                        <th class="text-center">Basic</th>
                        <th class="text-center">Premium</th>
                        <th class="text-center">Elite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Gym Access</strong></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td><strong>24/7 Access</strong></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td><strong>Group Classes</strong></td>
                        <td class="text-center">Limited</td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td><strong>Personal Training</strong></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center">4 sessions</td>
                        <td class="text-center">Unlimited</td>
                    </tr>
                    <tr>
                        <td><strong>Nutrition Consultation</strong></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td><strong>Progress Tracking</strong></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td><strong>Priority Support</strong></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td><strong>VIP Services</strong></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Frequently Asked Questions</h2>
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Can I cancel my membership anytime?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can cancel your membership anytime without penalties. We offer month-to-month flexibility so you're never locked in.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Do you offer a free trial?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely! We offer a complimentary 7-day trial so you can experience our facilities before committing.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Can I upgrade or downgrade my plan?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can change your plan anytime. Changes take effect at the beginning of your next billing cycle.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Do you offer group discounts?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! We offer special discounts for groups of 5 or more members. Contact our team for details.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept credit/debit cards, M-Pesa, bank transfers, and cash payments. Payments are secure and encrypted.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                Is personal training included in the membership?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Personal training is included in Premium and Elite plans. Basic members can purchase additional sessions.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Why Join FitPro Gym?</h2>
        
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold">State-of-the-Art Facilities</h5>
                        <p class="text-muted">
                            Access to modern equipment, multiple studios, and wellness amenities.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold">Expert Trainers</h5>
                        <p class="text-muted">
                            Certified professionals ready to guide and motivate your fitness journey.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold">Supportive Community</h5>
                        <p class="text-muted">
                            Join a welcoming community of fitness enthusiasts with shared goals.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold">Flexible Commitment</h5>
                        <p class="text-muted">
                            No long-term contracts - upgrade, downgrade, or cancel anytime.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-dark text-light">
    <div class="container-fluid px-4 text-center" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">Ready to Transform Your Body?</h2>
        <p class="fs-5 mb-4">
            Join thousands of members achieving their fitness goals at FitPro Gym
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <button class="btn btn-gradient btn-lg" data-bs-toggle="modal" data-bs-target="#joinModal">
                <i class="fas fa-sign-up-alt me-2"></i>Join Now
            </button>
            <a href="contact.php" class="btn btn-outline-light btn-lg">
                <i class="fas fa-phone me-2"></i>Contact Us
            </a>
        </div>
    </div>
</section>

<!-- Join Modal -->
<div class="modal fade" id="joinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Join FitPro Gym</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="joinForm" novalidate>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="tel" class="form-control" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="plan" class="form-label">Membership Plan *</label>
                        <select class="form-select" id="plan" required>
                            <option value="">Select a plan</option>
                            <?php
                            $plansQuery = $conn->query("SELECT * FROM membership_plans");
                            while ($plan = $plansQuery->fetch_assoc()):
                            ?>
                            <option value="<?php echo htmlspecialchars($plan['plan_name']); ?>">
                                <?php echo htmlspecialchars($plan['plan_name']); ?> - KES <?php echo number_format($plan['price'], 0); ?>/month
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        We'll contact you shortly to complete your registration.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-gradient" onclick="submitJoinForm()">
                    <i class="fas fa-arrow-right me-2"></i>Continue
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>

<script>
    function setPlan(planName, price) {
        document.getElementById('plan').value = planName;
    }
    
    function submitJoinForm() {
        const form = document.getElementById('joinForm');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Here you would send the form data to your backend
        showAlert('Thank you for your interest! We will contact you shortly.', 'success');
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('joinModal'));
        modal.hide();
    }
</script>


