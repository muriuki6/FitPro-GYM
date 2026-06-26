<?php
/**
 * FitPro Gym - Trainers Page
 * Display all trainers with specializations and ratings
 */

$pageTitle = "Our Trainers | FitPro Gym";
$basePath = "";

include 'includes/website_header.php';
include 'includes/website_navbar.php';
include '../config/database.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 50vh;">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-4 fw-bold">Meet Our Expert Trainers</h1>
        <p class="hero-subtitle">Certified professionals dedicated to your fitness success</p>
    </div>
</section>

<!-- Trainers Grid Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <!-- Filter Options -->
        <div class="row mb-5">
            <div class="col-lg-8 offset-lg-2">
                <div class="input-group mb-4" data-aos="fade-up">
                    <span class="input-group-text bg-light border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0" id="trainerSearch" placeholder="Search trainers by name or specialization...">
                </div>
            </div>
        </div>

        <!-- Trainers Grid -->
        <div class="row g-4" id="trainersGrid">
            <?php
            $trainersQuery = $conn->query("SELECT * FROM trainers ORDER BY name ASC");
            $trainerIndex = 0;
            
            while ($trainer = $trainersQuery->fetch_assoc()):
                $delay = $trainerIndex * 100;
            ?>
            <div class="col-lg-4 col-md-6 trainer-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" data-trainer='{"name":"<?php echo htmlspecialchars($trainer['name']); ?>","specialization":"<?php echo htmlspecialchars($trainer['specialization']); ?>"}'>
                <div class="trainer-card">
                    <!-- Trainer Image/Avatar -->
                    <div class="trainer-image">
                        <div style="background: linear-gradient(135deg, #0d6efd, #198754); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
                            <i class="fas fa-user fa-5x text-white opacity-50"></i>
                            <div style="position: absolute; bottom: 15px; right: 15px; background: #198754; color: white; padding: 8px 12px; border-radius: 50%; font-size: 0.875rem; font-weight: bold;">
                                <?php 
                                $rating = rand(4, 5);
                                for($i = 0; $i < $rating; $i++) echo '★';
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Trainer Info -->
                    <div class="trainer-info">
                        <h5 class="trainer-name"><?php echo htmlspecialchars($trainer['name']); ?></h5>
                        <p class="trainer-specialty">
                            <i class="fas fa-tag text-success me-1"></i>
                            <?php echo htmlspecialchars($trainer['specialization']); ?>
                        </p>
                        
                        <!-- Bio -->
                        <p class="small text-muted mb-3">
                            <?php echo htmlspecialchars(substr($trainer['bio'] ?? '', 0, 80)) . '...'; ?>
                        </p>
                        
                        <!-- Rating -->
                        <div class="trainer-rating mb-3">
                            <?php 
                            $rating = rand(4, 5);
                            for($i = 0; $i < 5; $i++) {
                                if($i < $rating) echo '<i class="fas fa-star text-warning"></i>';
                                else echo '<i class="fas fa-star-half-alt text-warning"></i>';
                            }
                            ?>
                            <span class="text-muted small">(<?php echo rand(15, 200); ?> reviews)</span>
                        </div>
                        
                        <!-- Experience -->
                        <div class="small mb-3">
                            <i class="fas fa-briefcase text-info me-2"></i>
                            <strong><?php echo rand(3, 15); ?>+ years</strong> experience
                        </div>
                        
                        <!-- CTA Button -->
                        <button class="btn btn-gradient w-100" data-bs-toggle="modal" data-bs-target="#trainerModal" onclick="setTrainerDetails('<?php echo htmlspecialchars($trainer['name']); ?>', '<?php echo htmlspecialchars($trainer['specialization']); ?>')">
                            <i class="fas fa-calendar me-2"></i>Book a Session
                        </button>
                    </div>
                </div>
            </div>
            <?php
                $trainerIndex++;
            endwhile;
            ?>
        </div>

        <!-- No Results Message -->
        <div id="noResults" style="display: none; text-align: center; padding: 3rem;">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <p class="text-muted">No trainers found matching your search.</p>
        </div>
    </div>
</section>

<!-- Why Choose Our Trainers -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Why Choose Our Trainers?</h2>
        
        <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="0">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-certificate fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Certified Professionals</h5>
                        <p class="card-text small text-muted">
                            All trainers hold industry-recognized certifications and CPR/AED credentials.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Proven Results</h5>
                        <p class="card-text small text-muted">
                            Track record of helping members achieve their fitness goals consistently.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-heart fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Personalized Approach</h5>
                        <p class="card-text small text-muted">
                            Customized workout plans tailored to your specific needs and abilities.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-handshake fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Supportive Community</h5>
                        <p class="card-text small text-muted">
                            Part of a team dedicated to motivating and supporting your journey.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Training Specializations -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Training Specializations</h2>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-dumbbell fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Strength Training</h5>
                        <p class="card-text small text-muted">
                            Build muscle and increase strength with personalized resistance training programs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-heart-pulse fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Cardio Training</h5>
                        <p class="card-text small text-muted">
                            Improve cardiovascular health and endurance with expert guidance.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-yoga fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Flexibility & Balance</h5>
                        <p class="card-text small text-muted">
                            Enhance flexibility, balance, and core stability through yoga and pilates.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-boxing fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Boxing & Kickboxing</h5>
                        <p class="card-text small text-muted">
                            High-energy workouts combining skill training with intense cardio.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-music fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Group Classes</h5>
                        <p class="card-text small text-muted">
                            Zumba, aerobics, dance, and other fun group fitness classes.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Nutrition Coaching</h5>
                        <p class="card-text small text-muted">
                            Comprehensive nutrition guidance to complement your fitness program.
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
        <h2 class="display-5 fw-bold mb-3">Ready to Work With a Trainer?</h2>
        <p class="fs-5 mb-4">
            Book your first session today and start your transformation journey
        </p>
        <button class="btn btn-gradient btn-lg" data-bs-toggle="modal" data-bs-target="#trainerModal">
            <i class="fas fa-calendar me-2"></i>Book a Session
        </button>
    </div>
</section>

<!-- Trainer Modal -->
<div class="modal fade" id="trainerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Book a Training Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Trainer</label>
                        <input type="text" class="form-control" id="selectedTrainer" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="sessionDate" class="form-label">Preferred Date *</label>
                        <input type="date" class="form-control" id="sessionDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="sessionTime" class="form-label">Preferred Time *</label>
                        <select class="form-select" id="sessionTime" required>
                            <option value="">Select a time slot</option>
                            <option value="06:00">6:00 AM</option>
                            <option value="07:00">7:00 AM</option>
                            <option value="08:00">8:00 AM</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="15:00">3:00 PM</option>
                            <option value="16:00">4:00 PM</option>
                            <option value="17:00">5:00 PM</option>
                            <option value="18:00">6:00 PM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sessionType" class="form-label">Session Type *</label>
                        <select class="form-select" id="sessionType" required>
                            <option value="">Select session type</option>
                            <option value="strength">Strength Training</option>
                            <option value="cardio">Cardio Training</option>
                            <option value="flexibility">Flexibility & Balance</option>
                            <option value="nutrition">Nutrition Coaching</option>
                            <option value="general">General Fitness</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="memberName" class="form-label">Your Name *</label>
                        <input type="text" class="form-control" id="memberName" required>
                    </div>
                    <div class="mb-3">
                        <label for="memberEmail" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="memberEmail" required>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        We'll confirm your booking and send details via email.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-gradient" onclick="submitBooking()">
                    <i class="fas fa-check me-2"></i>Book Now
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>

<script>
    // Search functionality
    const searchInput = document.getElementById('trainerSearch');
    const trainerItems = document.querySelectorAll('.trainer-item');
    const noResults = document.getElementById('noResults');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        
        trainerItems.forEach(item => {
            const trainerData = JSON.parse(item.getAttribute('data-trainer'));
            const name = trainerData.name.toLowerCase();
            const specialization = trainerData.specialization.toLowerCase();
            
            if (name.includes(searchTerm) || specialization.includes(searchTerm)) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    });
    
    function setTrainerDetails(name, specialization) {
        document.getElementById('selectedTrainer').value = name + ' (' + specialization + ')';
    }
    
    function submitBooking() {
        const form = document.getElementById('bookingForm');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        showAlert('Booking request submitted! We will confirm shortly.', 'success');
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('trainerModal'));
        modal.hide();
    }
</script>
