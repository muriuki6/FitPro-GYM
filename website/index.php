<?php
/**
 * FitPro Gym - Homepage
 * Premium fitness website with dynamic content from database
 */

// Set page variables
$pageTitle = "Premium Fitness Center | FitPro Gym";
$basePath = "";

// Include header
include 'includes/website_header.php';

// Include navbar
include 'includes/website_navbar.php';

// Database connection
include '../config/database.php';

// Fetch statistics from database
$memberCount = $conn->query("SELECT COUNT(*) as count FROM members")->fetch_assoc()['count'];
$trainerCount = $conn->query("SELECT COUNT(*) as count FROM trainers")->fetch_assoc()['count'];
$classCount = $conn->query("SELECT COUNT(*) as count FROM classes")->fetch_assoc()['count'];

?>

<!-- Loading Screen -->
<div class="loading-screen" id="loadingScreen">
    <div class="spinner"></div>
</div>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-3 fw-bold mb-4">
            Transform Your Body,<br>
            <span class="text-gradient">Transform Your Life</span>
        </h1>
        <p class="hero-subtitle mb-4">
            Join FitPro Gym - Your Premier Fitness Destination with Expert Trainers & State-of-the-Art Equipment
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="#membership" class="btn btn-gradient btn-lg">
                <i class="fas fa-dumbbell me-2"></i>Join Now
            </a>
            <a href="#contact" class="btn btn-outline-light btn-lg">
                <i class="fas fa-phone me-2"></i>Contact Us
            </a>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="0">
                <div class="stat-card text-center">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="<?php echo $memberCount; ?>">0</span>
                    <span class="stat-label">Active Members</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card text-center">
                    <i class="fas fa-dumbbell fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="<?php echo $trainerCount; ?>">0</span>
                    <span class="stat-label">Expert Trainers</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card text-center">
                    <i class="fas fa-heart fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="<?php echo $classCount; ?>">0</span>
                    <span class="stat-label">Group Classes</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card text-center">
                    <i class="fas fa-star fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="4">0</span>
                    <span class="stat-label">Star Rating</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="assets/images/gym-facility.jpg" alt="FitPro Gym Facility" class="img-fluid rounded-3" style="box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title text-start mb-3">Why Choose FitPro Gym?</h2>
                <p class="mb-3">
                    At FitPro Gym, we believe fitness is more than just exercise—it's a lifestyle. Our state-of-the-art facility is equipped with the latest technology and staffed by certified fitness professionals dedicated to your success.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Expert Trainers</strong> - Certified professionals to guide your fitness journey
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Modern Equipment</strong> - Latest fitness technology and equipment
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Diverse Classes</strong> - Yoga, CrossFit, Zumba, Boxing, and more
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Personalized Plans</strong> - Customized workout and nutrition plans
                    </li>
                </ul>
                <a href="about.php" class="btn btn-gradient mt-4">
                    Learn More About Us <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Membership Plans Section -->
<section class="py-5 bg-light" id="membership">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Our Membership Plans</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Flexible plans designed to fit your fitness goals and budget
        </p>
        
        <div class="row g-4">
            <?php
            // Fetch membership plans from database
            $plansQuery = $conn->query("SELECT * FROM membership_plans ORDER BY price ASC");
            $planIndex = 0;
            
            while ($plan = $plansQuery->fetch_assoc()):
                $isPopular = ($plan['name'] == 'Premium' || $plan['name'] == 'Pro');
                $delay = $planIndex * 100;
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="membership-card <?php echo $isPopular ? 'featured' : ''; ?>">
                    <?php if ($isPopular): ?>
                        <span class="badge badge-gradient">Most Popular</span>
                    <?php endif; ?>
                    
                    <h3 class="h4 mb-2"><?php echo htmlspecialchars($plan['name']); ?></h3>
                    <div class="plan-price">
                        <?php echo htmlspecialchars($plan['price']); ?>
                        <span class="text-muted fs-6">/month</span>
                    </div>
                    
                    <p class="text-muted small mb-3">
                        <?php echo htmlspecialchars($plan['description']); ?>
                    </p>
                    
                    <ul class="plan-features">
                        <li>Gym Access</li>
                        <li>Group Classes</li>
                        <li>Member Support</li>
                        <?php if (strpos($plan['name'], 'Premium') !== false || strpos($plan['name'], 'Pro') !== false): ?>
                            <li>Personal Training</li>
                            <li>Nutrition Consultation</li>
                        <?php endif; ?>
                    </ul>
                    
                    <a href="membership.php" class="btn btn-gradient w-100">
                        Join Now
                    </a>
                </div>
            </div>
            <?php
                $planIndex++;
            endwhile;
            ?>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="membership.php" class="btn btn-outline-primary btn-lg">
                View All Plans <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Featured Trainers Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Meet Our Expert Trainers</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Certified professionals dedicated to your fitness success
        </p>
        
        <div class="row g-4">
            <?php
            // Fetch trainers from database
            $trainersQuery = $conn->query("SELECT * FROM trainers LIMIT 6");
            $trainerIndex = 0;
            
            while ($trainer = $trainersQuery->fetch_assoc()):
                $delay = $trainerIndex * 100;
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="trainer-card">
                    <div class="trainer-image">
                        <div style="background: linear-gradient(135deg, #0d6efd, #198754); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user fa-5x text-white"></i>
                        </div>
                    </div>
                    <div class="trainer-info">
                        <h5 class="trainer-name"><?php echo htmlspecialchars($trainer['name']); ?></h5>
                        <p class="trainer-specialty">
                            <?php echo htmlspecialchars($trainer['specialization']); ?>
                        </p>
                        <p class="small text-muted mb-3">
                            <?php echo htmlspecialchars(substr($trainer['bio'] ?? '', 0, 60)) . '...'; ?>
                        </p>
                        <div class="trainer-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $trainerIndex++;
            endwhile;
            ?>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="trainers.php" class="btn btn-outline-primary btn-lg">
                View All Trainers <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">What Our Members Say</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Real stories from real fitness enthusiasts
        </p>
        
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "FitPro Gym changed my life! The trainers are incredibly supportive and the equipment is top-notch. I've never felt more motivated!"
                    </p>
                    <p class="testimonial-author">Sarah Johnson</p>
                    <p class="testimonial-title">Fitness Enthusiast</p>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Best gym experience ever! The community here is amazing and the personal training has helped me achieve my goals faster than expected."
                    </p>
                    <p class="testimonial-author">Mike Chen</p>
                    <p class="testimonial-title">Personal Training Client</p>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "The variety of classes at FitPro keeps my workouts fresh and exciting. I look forward to coming here every day!"
                    </p>
                    <p class="testimonial-author">Emma Williams</p>
                    <p class="testimonial-title">Group Classes Member</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-dark text-light">
    <div class="container-fluid px-4 text-center" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">Ready to Start Your Fitness Journey?</h2>
        <p class="fs-5 mb-4">
            Join thousands of members achieving their fitness goals at FitPro Gym
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="#membership" class="btn btn-gradient btn-lg">
                <i class="fas fa-sign-up-alt me-2"></i>Get Started Today
            </a>
            <a href="#contact" class="btn btn-outline-light btn-lg">
                <i class="fas fa-calendar me-2"></i>Book a Tour
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>

<script>
    // Remove loading screen after page loads
    window.addEventListener('load', () => {
        const loadingScreen = document.getElementById('loadingScreen');
        if (loadingScreen) {
            loadingScreen.style.display = 'none';
        }
    });
</script>

