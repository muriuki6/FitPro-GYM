<?php
/**
 * FitPro Gym - Contact Us Page
 * Contact form, location, hours, and social links
 */

$pageTitle = "Contact Us | FitPro Gym";
$basePath = "";

include 'includes/website_header.php';
include 'includes/website_navbar.php';
include __DIR__ . '/../config/database.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 50vh;">
    <div class="hero-content" data-aos="fade-up">
        <h1 class="display-4 fw-bold">Get in Touch</h1>
        <p class="hero-subtitle">We're here to help you with any questions</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="section-title text-start mb-4">Send us a Message</h2>
                
                <form id="contactForm" novalidate>
                    <div class="mb-3">
                        <label for="contactName" class="form-label fw-semibold">Full Name *</label>
                        <input type="text" class="form-control" id="contactName" required>
                        <div class="invalid-feedback">Please provide your name.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label fw-semibold">Email Address *</label>
                        <input type="email" class="form-control" id="contactEmail" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactPhone" class="form-label fw-semibold">Phone Number</label>
                        <input type="tel" class="form-control" id="contactPhone">
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactSubject" class="form-label fw-semibold">Subject *</label>
                        <select class="form-select" id="contactSubject" required>
                            <option value="">Select a subject</option>
                            <option value="membership">Membership Inquiry</option>
                            <option value="training">Personal Training</option>
                            <option value="classes">Classes</option>
                            <option value="facilities">Facilities</option>
                            <option value="general">General Question</option>
                            <option value="feedback">Feedback</option>
                        </select>
                        <div class="invalid-feedback">Please select a subject.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactMessage" class="form-label fw-semibold">Message *</label>
                        <textarea class="form-control" id="contactMessage" rows="5" required></textarea>
                        <div class="invalid-feedback">Please provide a message.</div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="contactTerms" required>
                        <label class="form-check-label" for="contactTerms">
                            I agree to be contacted about my inquiry
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient btn-lg w-100">
                        <i class="fas fa-paper-plane me-2"></i>Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title text-start mb-4">Contact Information</h2>
                
                <!-- Address -->
                <div class="mb-4">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marker-alt fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold">Location</h5>
                            <p class="text-muted mb-0">
                                123 Fitness Street<br>
                                Nairobi, Kenya 00100<br>
                                East Africa
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Phone -->
                <div class="mb-4">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-phone fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold">Phone</h5>
                            <p class="text-muted mb-0">
                                +254 700 000 000<br>
                                +254 701 000 000<br>
                                Mon - Sun: 6:00 AM - 10:00 PM
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="mb-4">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-envelope fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold">Email</h5>
                            <p class="text-muted mb-0">
                                <a href="mailto:info@fitprogym.com" class="text-muted text-decoration-none">
                                    info@fitprogym.com
                                </a><br>
                                <a href="mailto:support@fitprogym.com" class="text-muted text-decoration-none">
                                    support@fitprogym.com
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Hours -->
                <div class="mb-4">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold">Business Hours</h5>
                            <p class="text-muted mb-0">
                                <strong>Monday - Friday:</strong> 6:00 AM - 10:00 PM<br>
                                <strong>Saturday:</strong> 7:00 AM - 8:00 PM<br>
                                <strong>Sunday:</strong> 8:00 AM - 6:00 PM<br>
                                <strong>Holidays:</strong> 9:00 AM - 4:00 PM
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h5 class="fw-bold mb-3">Follow Us</h5>
                    <div class="d-flex gap-2">
                        <a href="https://facebook.com/fitprogym" class="btn btn-outline-success rounded-circle" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com/fitprogym" class="btn btn-outline-success rounded-circle" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://twitter.com/fitprogym" class="btn btn-outline-success rounded-circle" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://youtube.com/fitprogym" class="btn btn-outline-success rounded-circle" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://wa.me/254700000000" class="btn btn-outline-success rounded-circle" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4" data-aos="fade-up">
        <h2 class="section-title mb-5">Find Us on the Map</h2>
        
        <div style="width: 100%; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8154!2d36.8!3d-1.3!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f17d5c5c5c5c5%3A0x0!2sFitPro%20Gym!5e0!3m2!1sen!2ske" width="100%" height="450" style="border:none;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="section-title mb-5" data-aos="fade-up">Frequently Asked Questions</h2>
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="contactFaqAccordion" data-aos="fade-up">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What is your response time for inquiries?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                We typically respond to all inquiries within 24 hours on business days. For urgent matters, please call us directly.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Do you offer gym tours?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                Yes! We offer complimentary facility tours. Please contact us to schedule a tour at your convenience.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Can I visit the gym before joining?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                Absolutely! We offer a 7-day free trial for new members. No credit card required.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How can I become a member?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                You can join by visiting our facility, calling us, or filling out our membership form on our website.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Do you have corporate packages?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                Yes, we offer special corporate membership packages. Contact our corporate team for more details.
                            </div>
                        </div>
                    </div>
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
            Visit us today or book your free trial online
        </p>
        <a href="membership.php" class="btn btn-gradient btn-lg">
            <i class="fas fa-sign-up-alt me-2"></i>Join Now
        </a>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/website_footer.php'; ?>

<script>
    // Contact form submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (this.checkValidity() === false) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }
        
        // Here you would send the form data to your backend
        const formData = {
            name: document.getElementById('contactName').value,
            email: document.getElementById('contactEmail').value,
            phone: document.getElementById('contactPhone').value,
            subject: document.getElementById('contactSubject').value,
            message: document.getElementById('contactMessage').value,
            timestamp: new Date().toISOString()
        };
        
        console.log('Contact form data:', formData);
        
        showAlert('Thank you for your message! We will get back to you shortly.', 'success');
        this.reset();
        this.classList.remove('was-validated');
    });
</script>

