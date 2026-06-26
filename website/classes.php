<?php
/**
 * FitPro Gym - Classes Page
 * Display fitness classes with schedule and details
 */

$pageTitle = "Classes | FitPro Gym";
$basePath = "";

include 'includes/website_header.php';
include 'includes/website_navbar.php';
include '../config/database.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 50vh;">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-4 fw-bold">Our Classes</h1>
        <p class="hero-subtitle">Energizing group fitness classes for all levels</p>
    </div>
</section>

<!-- Classes Grid Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <!-- Filter Options -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-12">
                <div class="d-flex gap-2 flex-wrap justify-content-center">
                    <button class="btn btn-outline-success filter-btn active" data-filter="all">All Classes</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="cardio">Cardio</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="strength">Strength</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="mind-body">Mind & Body</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="dance">Dance</button>
                </div>
            </div>
        </div>

        <!-- Classes Grid -->
        <div class="row g-4" id="classesGrid">
            <?php
            $classesQuery = $conn->query("SELECT * FROM classes ORDER BY name ASC");
            $classIndex = 0;
            
            while ($class = $classesQuery->fetch_assoc()):
                $category = strtolower(str_replace(' ', '-', $class['category'] ?? 'other'));
                $delay = $classIndex * 100;
            ?>
            <div class="col-lg-4 col-md-6 class-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" data-category="<?php echo $category; ?>">
                <div class="card h-100">
                    <div style="background: linear-gradient(135deg, #0d6efd, #198754); height: 200px; display: flex; align-items: center; justify-content: center; position: relative;">
                        <i class="fas fa-dumbbell fa-5x text-white opacity-30"></i>
                        <span style="position: absolute; top: 15px; right: 15px; background: #fff; color: #198754; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold;">
                            <?php echo htmlspecialchars($class['category'] ?? 'Fitness'); ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($class['name']); ?></h5>
                        
                        <p class="card-text text-muted mb-3">
                            <?php echo htmlspecialchars(substr($class['description'] ?? '', 0, 100)) . '...'; ?>
                        </p>
                        
                        <!-- Class Details -->
                        <div class="mb-3 small">
                            <div class="mb-2">
                                <i class="fas fa-user text-success me-2"></i>
                                <strong>Instructor:</strong> <?php echo htmlspecialchars($class['instructor'] ?? 'TBA'); ?>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-clock text-success me-2"></i>
                                <strong>Duration:</strong> <?php echo htmlspecialchars($class['duration'] ?? '60'); ?> min
                            </div>
                            <div>
                                <i class="fas fa-users text-success me-2"></i>
                                <strong>Level:</strong> <?php echo htmlspecialchars($class['level'] ?? 'All'); ?>
                            </div>
                        </div>
                        
                        <button class="btn btn-gradient w-100" data-bs-toggle="modal" data-bs-target="#classModal" onclick="setClassDetails('<?php echo htmlspecialchars($class['name']); ?>')">
                            <i class="fas fa-calendar me-2"></i>Enroll Now
                        </button>
                    </div>
                </div>
            </div>
            <?php
                $classIndex++;
            endwhile;
            ?>
        </div>
    </div>
</section>

<!-- Weekly Timetable Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Weekly Schedule</h2>
        
        <div class="table-responsive" data-aos="fade-up">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Time</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>6:00 AM</strong></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                        <td><span class="badge bg-warning text-dark">Zumba</span></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                        <td><span class="badge bg-info">Pilates</span></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                        <td><span class="badge bg-danger">Boxing</span></td>
                    </tr>
                    <tr>
                        <td><strong>7:00 AM</strong></td>
                        <td><span class="badge bg-danger">Boxing</span></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                        <td><span class="badge bg-danger">Boxing</span></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                        <td><span class="badge bg-danger">Boxing</span></td>
                        <td><span class="badge bg-warning text-dark">CrossFit</span></td>
                    </tr>
                    <tr>
                        <td><strong>5:30 PM</strong></td>
                        <td><span class="badge bg-warning text-dark">Zumba</span></td>
                        <td><span class="badge bg-danger">Boxing</span></td>
                        <td><span class="badge bg-warning text-dark">Zumba</span></td>
                        <td><span class="badge bg-danger">Boxing</span></td>
                        <td><span class="badge bg-info">Pilates</span></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                    </tr>
                    <tr>
                        <td><strong>6:30 PM</strong></td>
                        <td><span class="badge bg-info">Pilates</span></td>
                        <td><span class="badge bg-warning text-dark">Zumba</span></td>
                        <td><span class="badge bg-info">Pilates</span></td>
                        <td><span class="badge bg-warning text-dark">Zumba</span></td>
                        <td><span class="badge bg-success">Yoga</span></td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Class Categories Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Class Categories</h2>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                        <h5 class="card-title fw-bold">Cardio</h5>
                        <p class="card-text small text-muted">
                            High-energy classes to boost your cardiovascular fitness and endurance.
                        </p>
                        <p class="text-success fw-semibold">Boxing, Zumba, Aerobics</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-dumbbell fa-3x text-warning mb-3"></i>
                        <h5 class="card-title fw-bold">Strength</h5>
                        <p class="card-text small text-muted">
                            Build muscle and increase overall strength with targeted exercises.
                        </p>
                        <p class="text-success fw-semibold">CrossFit, BootCamp</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-spa fa-3x text-info mb-3"></i>
                        <h5 class="card-title fw-bold">Mind & Body</h5>
                        <p class="card-text small text-muted">
                            Improve flexibility, balance, and mental wellness through mindful movement.
                        </p>
                        <p class="text-success fw-semibold">Yoga, Pilates</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-music fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Dance</h5>
                        <p class="card-text small text-muted">
                            Fun, rhythmic classes that combine fitness with entertainment.
                        </p>
                        <p class="text-success fw-semibold">Zumba, Dance Cardio</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Why Join Our Classes?</h2>
        
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold">Community & Motivation</h5>
                        <p class="text-muted">
                            Work out with like-minded individuals and stay motivated together.
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
                        <h5 class="fw-bold">Expert Instruction</h5>
                        <p class="text-muted">
                            Learn proper form and techniques from certified instructors.
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
                        <h5 class="fw-bold">Variety & Fun</h5>
                        <p class="text-muted">
                            Different classes keep your workouts fresh and enjoyable.
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
                        <h5 class="fw-bold">Structured Program</h5>
                        <p class="text-muted">
                            Scheduled classes help you maintain consistency and commitment.
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
        <h2 class="display-5 fw-bold mb-3">Ready to Join a Class?</h2>
        <p class="fs-5 mb-4">
            Experience the energy and support of group fitness at FitPro Gym
        </p>
        <button class="btn btn-gradient btn-lg" data-bs-toggle="modal" data-bs-target="#classModal">
            <i class="fas fa-calendar me-2"></i>Enroll Now
        </button>
    </div>
</section>

<!-- Class Enrollment Modal -->
<div class="modal fade" id="classModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Enroll in Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="enrollForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Class</label>
                        <input type="text" class="form-control" id="selectedClass" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="enrollDate" class="form-label">Preferred Start Date *</label>
                        <input type="date" class="form-control" id="enrollDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="enrollName" class="form-label">Your Name *</label>
                        <input type="text" class="form-control" id="enrollName" required>
                    </div>
                    <div class="mb-3">
                        <label for="enrollEmail" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="enrollEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="enrollPhone" class="form-label">Phone Number *</label>
                        <input type="tel" class="form-control" id="enrollPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="fitnessLevel" class="form-label">Fitness Level *</label>
                        <select class="form-select" id="fitnessLevel" required>
                            <option value="">Select level</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">
                            I agree to the class participation policy
                        </label>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        We'll send class details and instructions to your email.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-gradient" onclick="submitEnrollment()">
                    <i class="fas fa-check me-2"></i>Enroll
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>

<script>
    // Class filtering
    const filterButtons = document.querySelectorAll('.filter-btn');
    const classItems = document.querySelectorAll('.class-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            classItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    function setClassDetails(className) {
        document.getElementById('selectedClass').value = className;
    }
    
    function submitEnrollment() {
        const form = document.getElementById('enrollForm');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        showAlert('Enrollment successful! Check your email for class details.', 'success');
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('classModal'));
        modal.hide();
    }
</script>
