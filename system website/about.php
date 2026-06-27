<?php
/**
 * FitPro Gym - About Us Page
 * Gym story, mission, vision, and facilities
 */

$pageTitle = "About Us | FitPro Gym";
$basePath = "";

include 'includes/website_header.php';
include 'includes/website_navbar.php';
include '../config/database.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 50vh;">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-4 fw-bold">About FitPro Gym</h1>
        <p class="hero-subtitle">Your Premier Destination for Fitness Excellence</p>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="section-title text-start">Our Story</h2>
                <p class="mb-3">
                    FitPro Gym was founded with a simple mission: to make premium fitness accessible to everyone. What started as a small facility with basic equipment has grown into a state-of-the-art fitness center serving thousands of dedicated members.
                </p>
                <p class="mb-3">
                    We believe that fitness is a journey, not a destination. Our team is committed to providing the best equipment, expert guidance, and a supportive community to help you achieve your goals.
                </p>
                <p>
                    Today, FitPro Gym stands as a leader in the fitness industry, known for our innovation, customer care, and commitment to health and wellness.
                </p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div style="background: linear-gradient(135deg, #0d6efd, #198754); border-radius: 1rem; height: 400px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-building fa-5x text-white opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="0">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-bullseye fa-2x text-success mb-3"></i>
                        <h3 class="card-title fw-bold mb-3">Our Mission</h3>
                        <p class="card-text">
                            To empower individuals to achieve their fitness goals by providing access to world-class facilities, expert trainers, and supportive community. We are committed to making fitness an integral part of everyone's lifestyle.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-eye fa-2x text-success mb-3"></i>
                        <h3 class="card-title fw-bold mb-3">Our Vision</h3>
                        <p class="card-text">
                            To be the most trusted and innovative fitness center in the region, recognized for our commitment to excellence, community impact, and member satisfaction. We envision a healthier, stronger society.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Our Core Values</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Principles that guide everything we do
        </p>
        
        <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="0">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-heart fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Excellence</h5>
                        <p class="card-text small">
                            We strive for excellence in everything we do, from equipment maintenance to member service.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-handshake fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Community</h5>
                        <p class="card-text small">
                            We foster a supportive community where members motivate and inspire each other.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-lightbulb fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Innovation</h5>
                        <p class="card-text small">
                            We continuously invest in new equipment and programs to serve our members better.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Trust</h5>
                        <p class="card-text small">
                            We are committed to building trust through transparency and accountability.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Our Facilities</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            State-of-the-art equipment and amenities
        </p>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-dumbbell fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Weight Training</h5>
                        <p class="card-text small">
                            Complete range of free weights, machines, and equipment for strength training.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-running fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Cardio Zone</h5>
                        <p class="card-text small">
                            Modern treadmills, ellipticals, and stationary bikes with virtual training programs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-yoga fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Group Classes</h5>
                        <p class="card-text small">
                            Yoga, Pilates, Zumba, CrossFit, Boxing, and more in dedicated studio spaces.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-swimming-pool fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Pool & Spa</h5>
                        <p class="card-text small">
                            Olympic-size pool for swimming and aqua aerobics with sauna facilities.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Nutrition Center</h5>
                        <p class="card-text small">
                            Healthy café and nutrition consultation with certified nutritionists.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-shower fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Locker Rooms</h5>
                        <p class="card-text small">
                            Premium changing facilities with lockers, showers, and grooming amenities.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Our Journey</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Milestones in our fitness revolution
        </p>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline">
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="0">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2015 - The Beginning</h5>
                            <p class="text-muted mb-0">
                                FitPro Gym opened its doors with a mission to make fitness accessible to everyone in the community.
                            </p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2017 - Expansion</h5>
                            <p class="text-muted mb-0">
                                Expanded facilities to include pool, sauna, and specialized training studios.
                            </p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2019 - Digital Innovation</h5>
                            <p class="text-muted mb-0">
                                Launched mobile app and online training programs to reach members virtually.
                            </p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2021 - Community Impact</h5>
                            <p class="text-muted mb-0">
                                Achieved 5000+ active members and launched community wellness programs.
                            </p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2024 - Today</h5>
                            <p class="text-muted mb-0">
                                Operating at peak capacity with premium amenities and world-class service.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Certifications & Awards Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Certifications & Awards</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Industry recognition and accreditations
        </p>
        
        <div class="row g-4">
            <div class="col-md-3 text-center" data-aos="zoom-in" data-aos-delay="0">
                <div class="badge-box">
                    <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                    <h6 class="fw-bold">ISO 9001 Certified</h6>
                    <p class="text-muted small">Quality Management</p>
                </div>
            </div>
            <div class="col-md-3 text-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="badge-box">
                    <i class="fas fa-certificate fa-3x text-success mb-3"></i>
                    <h6 class="fw-bold">IHRSA Accredited</h6>
                    <p class="text-muted small">Health & Fitness</p>
                </div>
            </div>
            <div class="col-md-3 text-center" data-aos="zoom-in" data-aos-delay="200">
                <div class="badge-box">
                    <i class="fas fa-star fa-3x text-info mb-3"></i>
                    <h6 class="fw-bold">5-Star Rating</h6>
                    <p class="text-muted small">Member Satisfaction</p>
                </div>
            </div>
            <div class="col-md-3 text-center" data-aos="zoom-in" data-aos-delay="300">
                <div class="badge-box">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h6 class="fw-bold">Safety Certified</h6>
                    <p class="text-muted small">Health & Safety</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title" data-aos="fade-up">Leadership Team</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Meet the experts behind FitPro Gym
        </p>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card text-center">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 250px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-tie fa-5x text-white opacity-50"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">James Smith</h5>
                        <p class="text-success fw-semibold">Founder & CEO</p>
                        <p class="card-text small text-muted">
                            20+ years in fitness industry with passion for community wellness.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card text-center">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 250px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-tie fa-5x text-white opacity-50"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Emily Davis</h5>
                        <p class="text-success fw-semibold">Head of Operations</p>
                        <p class="card-text small text-muted">
                            Expert in gym management and member experience optimization.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 250px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-tie fa-5x text-white opacity-50"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Dr. Michael Brown</h5>
                        <p class="text-success fw-semibold">Head Trainer</p>
                        <p class="card-text small text-muted">
                            Certified personal trainer and fitness specialist with advanced qualifications.
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
        <h2 class="display-5 fw-bold mb-3">Join Our Fitness Community</h2>
        <p class="fs-5 mb-4">
            Experience the FitPro difference and transform your fitness journey today
        </p>
        <a href="membership.php" class="btn btn-gradient btn-lg">
            <i class="fas fa-sign-up-alt me-2"></i>Get Started
        </a>
    </div>
</section>

<style>
    .timeline {
        position: relative;
        padding: 2rem 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 3px;
        height: 100%;
        background: linear-gradient(135deg, #0d6efd, #198754);
    }
    
    .timeline-item {
        margin-bottom: 3rem;
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background: #198754;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 3px #f0f0f0;
        top: 0;
    }
    
    .timeline-content {
        width: 45%;
        margin-left: auto;
        padding-left: 2rem;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: 0;
        margin-right: auto;
        padding-left: 0;
        padding-right: 2rem;
        text-align: right;
    }
    
    .badge-box {
        padding: 2rem 1.5rem;
        border-radius: 1rem;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .badge-box:hover {
        background: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }
    
    @media (max-width: 768px) {
        .timeline::before {
            left: 15px;
        }
        
        .timeline-marker {
            left: 15px;
        }
        
        .timeline-content,
        .timeline-item:nth-child(even) .timeline-content {
            width: 100%;
            margin: 0;
            padding-left: 60px;
            padding-right: 0;
            text-align: left;
        }
    }
</style>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>
