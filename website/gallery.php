<?php
/**
 * FitPro Gym - Gallery Page
 * Showcase gym facilities and member moments
 */

$pageTitle = "Gallery | FitPro Gym";
$basePath = "";

include 'includes/website_header.php';
include 'includes/website_navbar.php';
include __DIR__ . '/../config/database.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 50vh;">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-4 fw-bold">Gallery</h1>
        <p class="hero-subtitle">Explore our facilities and member success stories</p>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <!-- Filter Buttons -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-12">
                <div class="d-flex gap-2 flex-wrap justify-content-center">
                    <button class="btn btn-outline-success filter-btn active" data-filter="all">All</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="facilities">Facilities</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="classes">Classes</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="trainers">Trainers</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="members">Members</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="events">Events</button>
                </div>
            </div>
        </div>

        <!-- Masonry Gallery Grid -->
        <div class="row g-4" id="galleryGrid">
            <?php
            // Gallery items data
            $galleryItems = [
                ['category' => 'facilities', 'title' => 'Main Gym Floor', 'icon' => 'dumbbell'],
                ['category' => 'facilities', 'title' => 'Cardio Zone', 'icon' => 'heart-pulse'],
                ['category' => 'facilities', 'title' => 'Olympic Pool', 'icon' => 'water'],
                ['category' => 'classes', 'title' => 'Group Classes', 'icon' => 'users'],
                ['category' => 'classes', 'title' => 'Yoga Studio', 'icon' => 'spa'],
                ['category' => 'classes', 'title' => 'Boxing Ring', 'icon' => 'boxing-glove'],
                ['category' => 'trainers', 'title' => 'Expert Trainers', 'icon' => 'user-tie'],
                ['category' => 'trainers', 'title' => 'Personal Sessions', 'icon' => 'handshake'],
                ['category' => 'members', 'title' => 'Member Success', 'icon' => 'star'],
                ['category' => 'members', 'title' => 'Community', 'icon' => 'people-group'],
                ['category' => 'events', 'title' => 'Gym Events', 'icon' => 'calendar'],
                ['category' => 'events', 'title' => 'Competitions', 'icon' => 'trophy'],
            ];

            $index = 0;
            foreach ($galleryItems as $item):
                $delay = ($index % 3) * 100;
            ?>
            <div class="col-lg-4 col-md-6 gallery-item-wrapper" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" data-category="<?php echo $item['category']; ?>">
                <div class="gallery-item" onclick="openLightbox('<?php echo htmlspecialchars($item['title']); ?>')">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); width: 100%; height: 250px; display: flex; align-items: center; justify-content: center; position: relative; cursor: pointer;">
                        <i class="fas fa-<?php echo $item['icon']; ?> fa-5x text-white opacity-30"></i>
                        <div class="gallery-overlay">
                            <i class="fas fa-plus fa-2x"></i>
                        </div>
                        <div style="position: absolute; bottom: 15px; left: 15px; background: rgba(25, 135, 84, 0.9); color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.875rem; font-weight: bold;">
                            <?php echo ucfirst($item['category']); ?>
                        </div>
                    </div>
                    <div class="p-3">
                        <h6 class="fw-bold mb-0"><?php echo $item['title']; ?></h6>
                    </div>
                </div>
            </div>
            <?php
                $index++;
            endforeach;
            ?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">By The Numbers</h2>
        
        <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="0">
                <div class="stat-card text-center">
                    <i class="fas fa-image fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="500">0</span>
                    <span class="stat-label">Photos</span>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card text-center">
                    <i class="fas fa-video fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="50">0</span>
                    <span class="stat-label">Videos</span>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card text-center">
                    <i class="fas fa-camera fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="100">0</span>
                    <span class="stat-label">Events Covered</span>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card text-center">
                    <i class="fas fa-heart fa-3x text-success mb-3"></i>
                    <span class="stat-number" data-count="10">0</span>
                    <span class="stat-label">Years of Memories</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Member Testimonials with Photos -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Member Success Stories</h2>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="card h-100">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 200px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user fa-5x text-white opacity-30"></i>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text italic text-muted mb-3">
                            "FitPro Gym transformed my life! I've lost 20kg and gained so much confidence in just 6 months."
                        </p>
                        <h6 class="fw-bold">John Kariuki</h6>
                        <p class="text-success small">Strength Training Member</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 200px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user fa-5x text-white opacity-30"></i>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text italic text-muted mb-3">
                            "The community at FitPro is amazing. I've made great friends and stay motivated every day!"
                        </p>
                        <h6 class="fw-bold">Jane Kipchoge</h6>
                        <p class="text-success small">Group Classes Enthusiast</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 200px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user fa-5x text-white opacity-30"></i>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text italic text-muted mb-3">
                            "Professional trainers, world-class facilities, and a supportive environment. Highly recommended!"
                        </p>
                        <h6 class="fw-bold">Mike Omondi</h6>
                        <p class="text-success small">Personal Training Client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Container -->
<div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.95); z-index: 9999; align-items: center; justify-content: center;">
    <div style="position: relative; width: 90%; max-width: 800px;">
        <button onclick="closeLightbox()" style="position: absolute; top: -40px; right: 0; background: none; border: none; color: white; font-size: 2rem; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
        <div style="background: linear-gradient(135deg, #0d6efd, #198754); width: 100%; height: 500px; display: flex; align-items: center; justify-content: center; border-radius: 1rem;">
            <div style="text-align: center;">
                <i class="fas fa-images fa-5x text-white opacity-50 mb-3"></i>
                <h5 class="text-white fw-bold" id="lightboxTitle">Gallery Image</h5>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="py-5 bg-dark text-light">
    <div class="container-fluid px-4 text-center" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">Become Part of Our Story</h2>
        <p class="fs-5 mb-4">
            Join thousands of members and create your own success story at FitPro Gym
        </p>
        <a href="membership.php" class="btn btn-gradient btn-lg">
            <i class="fas fa-sign-up-alt me-2"></i>Join Now
        </a>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>

<script>
    // Gallery filtering
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item-wrapper');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            galleryItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = '';
                    setTimeout(() => {
                        item.style.opacity = '1';
                    }, 10);
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Lightbox functionality
    function openLightbox(title) {
        document.getElementById('lightboxTitle').textContent = title;
        document.getElementById('lightbox').style.display = 'flex';
    }
    
    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
    }
    
    // Close lightbox on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
    
    // Close lightbox on background click
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
</script>

<style>
    .gallery-item {
        cursor: pointer;
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(25, 135, 84, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: white;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
</style>

