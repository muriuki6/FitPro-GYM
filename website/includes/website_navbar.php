<?php
/**
 * FitPro Gym - Website Navigation
 * Sticky navigation with mobile support
 */
$isHome = basename($_SERVER['PHP_SELF']) === 'index.php';
?>

<!-- Sticky Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm" id="mainNav">
    <div class="container-fluid px-4">
        <!-- Brand Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php">
            <i class="fas fa-dumbbell text-success me-2"></i>
            <span class="brand-text">FitPro</span>
        </a>
        
        <!-- Hamburger Menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link <?php echo $isHome ? 'active' : ''; ?>" href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo isset($basePath) ? $basePath : ''; ?>about.php">
                        <i class="fas fa-info-circle me-1"></i>About
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-barbell me-1"></i>Programs
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?php echo isset($basePath) ? $basePath : ''; ?>membership.php">Membership Plans</a></li>
                        <li><a class="dropdown-item" href="<?php echo isset($basePath) ? $basePath : ''; ?>classes.php">Classes</a></li>
                        <li><a class="dropdown-item" href="<?php echo isset($basePath) ? $basePath : ''; ?>trainers.php">Personal Trainers</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo isset($basePath) ? $basePath : ''; ?>gallery.php">
                        <i class="fas fa-images me-1"></i>Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo isset($basePath) ? $basePath : ''; ?>contact.php">
                        <i class="fas fa-envelope me-1"></i>Contact
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>../login.php" class="btn btn-sm btn-success">
                        <i class="fas fa-sign-in-alt me-1"></i>Member Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/254700000000?text=Hi%20FitPro%20Gym%20I%20would%20like%20to%20inquire%20about%20your%20services" 
   class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<script>
    // Navigation background on scroll
    const mainNav = document.getElementById('mainNav');
    if (mainNav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                mainNav.style.backgroundColor = 'rgba(17, 24, 39, 0.98)';
                mainNav.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
            } else {
                mainNav.style.backgroundColor = 'rgba(17, 24, 39, 0.95)';
                mainNav.style.boxShadow = 'none';
            }
        });
    }
</script>
