<?php
/**
 * FitPro Gym - Website Footer
 * Modern footer with links and CTA
 */
?>

<!-- Footer -->
<footer class="footer bg-dark text-light py-5 mt-5">
    <div class="container-fluid px-4">
        <div class="row g-4 mb-4">
            <!-- About Section -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title mb-3">
                    <i class="fas fa-dumbbell text-success me-2"></i>FitPro Gym
                </h5>
                <p class="text-muted small">
                    Premier fitness center dedicated to transforming lives through expert training and state-of-the-art facilities.
                </p>
                <div class="social-links">
                    <a href="#" class="text-light me-3" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-light me-3" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-light me-3" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-light" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-title mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="index.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="about.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="membership.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>Membership
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="contact.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Programs -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-title mb-3">Programs</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="classes.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>Group Classes
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="trainers.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>Personal Training
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="gallery.php" class="text-muted text-decoration-none">
                            <i class="fas fa-chevron-right me-2"></i>Gallery
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-title mb-3">Get in Touch</h6>
                <div class="contact-info">
                    <p class="text-muted small mb-2">
                        <i class="fas fa-map-marker-alt text-success me-2"></i>
                        123 Fitness Street, Nairobi, Kenya
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-phone text-success me-2"></i>
                        +254 700 000 000
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-envelope text-success me-2"></i>
                        info@fitprogym.com
                    </p>
                </div>
            </div>
        </div>

        <hr class="bg-secondary">

        <!-- Footer Bottom -->
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted small mb-0">
                    &copy; 2026 FitPro Gym. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted small mb-0">
                    <a href="#" class="text-muted text-decoration-none">Privacy Policy</a> | 
                    <a href="#" class="text-muted text-decoration-none">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top" title="Back to top">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS - Animate On Scroll -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Website JS -->
<script src="<?php echo isset($basePath) ? $basePath : ''; ?>assets/js/website-script.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Back to Top Button
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });
    
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

</body>
</html>
