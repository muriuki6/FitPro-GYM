<?php
$pageTitle = 'Contact FitPro Gym';
$pageDescription = 'Contact FitPro Gym, view business hours, map location, social media, and WhatsApp access.';
$activePage = 'contact';
include __DIR__ . '/includes/header.php';

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$message = '';
$messageType = 'info';

if($requestMethod === 'POST' && isset($_POST['send_contact'])){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['message'] ?? '');

    if($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $body === ''){
        $message = 'Please provide your name, a valid email, and message.';
        $messageType = 'danger';
    }else{
        $conn->query("CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            email VARCHAR(150) NOT NULL,
            phone VARCHAR(50) NULL,
            subject VARCHAR(180) NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $stmt = $conn->prepare("INSERT INTO contact_messages (name,email,phone,subject,message) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss', $name, $email, $phone, $subject, $body);
        $message = $stmt->execute() ? 'Thanks. Your message has been sent to the FitPro team.' : 'Message could not be saved. Please try WhatsApp.';
        $messageType = $stmt->error ? 'danger' : 'success';
        $stmt->close();
    }
}

if($requestMethod === 'POST' && isset($_POST['subscribe'])){
    $email = trim($_POST['newsletter_email'] ?? '');
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $conn->query("CREATE TABLE IF NOT EXISTS newsletter_subscriptions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(150) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        $stmt = $conn->prepare("INSERT IGNORE INTO newsletter_subscriptions (email) VALUES (?)");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->close();
        $message = 'You are subscribed to FitPro updates.';
        $messageType = 'success';
    }else{
        $message = 'Please enter a valid email address.';
        $messageType = 'danger';
    }
}
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-envelope"></i> Contact</span>
<h1 class="hero-title">Let Us Help You Start <span>Strong.</span></h1>
<p class="page-copy">Ask about memberships, trainers, classes, payments, or tours. The team will get you moving.</p>
</div>
</section>

<section class="section-pad">
<div class="container">
<?php if($message): ?><div class="alert alert-<?= h($messageType) ?> reveal"><?= h($message) ?></div><?php endif; ?>
<div class="row g-4">
<div class="col-lg-7 reveal">
<div class="premium-card p-4">
<h2 class="fw-bold mb-3">Send A Message</h2>
<form method="post">
<div class="row g-3">
<div class="col-md-6"><input class="form-control" name="name" placeholder="Full name" required></div>
<div class="col-md-6"><input class="form-control" type="email" name="email" placeholder="Email address" required></div>
<div class="col-md-6"><input class="form-control" name="phone" placeholder="Phone number"></div>
<div class="col-md-6"><input class="form-control" name="subject" placeholder="Subject"></div>
<div class="col-12"><textarea class="form-control" name="message" rows="5" placeholder="How can we help?" required></textarea></div>
<div class="col-12"><button class="btn btn-gradient" name="send_contact" type="submit">Send Message</button></div>
</div>
</form>
</div>
</div>

<div class="col-lg-5 reveal">
<div class="premium-card p-4 mb-4">
<h3 class="fw-bold">Business Hours</h3>
<p class="mb-2"><strong>Mon - Fri:</strong> 5:00 AM - 10:00 PM</p>
<p class="mb-2"><strong>Saturday:</strong> 6:00 AM - 9:00 PM</p>
<p class="mb-0"><strong>Sunday:</strong> 7:00 AM - 6:00 PM</p>
</div>

<!-- NEWSLETTER -->
<div id="newsletter" class="premium-card p-4 mt-4 reveal">
<div class="row align-items-center g-3">
<div class="col-lg-7">
<span class="section-kicker">Newsletter</span>
<h3 class="fw-bold mb-0">Training tips, class updates, and offers.</h3>
</div>
<div class="col-lg-5">
<form method="post" class="d-flex gap-2">
<input class="form-control" type="email" name="newsletter_email" placeholder="Email address" required>
<button class="btn btn-gradient" name="subscribe" type="submit">Subscribe</button>
</div>
</div>
</div>
</div>
</form>




<!-- MAP -->

<section class="container pb-5">

<div class="card contact-card overflow-hidden">

<iframe
src="https://maps.google.com/maps?q=Nairobi%20Kenya&t=&z=13&ie=UTF8&iwloc=&output=embed"
width="100%"
height="450"
style="border:0;"
allowfullscreen>
</iframe>

</div>

</section>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
