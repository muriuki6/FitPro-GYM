<?php
include '../config/database.php';

/* ===========================
   LIVE WEBSITE STATISTICS
=========================== */

$totalMembers = $conn->query("
SELECT COUNT(*) total
FROM members
")->fetch_assoc()['total'];

$totalTrainers = $conn->query("
SELECT COUNT(*) total
FROM trainers
")->fetch_assoc()['total'];

$totalPlans = $conn->query("
SELECT COUNT(*) total
FROM membership_plans
")->fetch_assoc()['total'];

$totalClasses = $conn->query("
SELECT COUNT(*) total
FROM classes
")->fetch_assoc()['total'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>FitPro Gym | Train Hard. Stay Strong.</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

html{
scroll-behavior:smooth;
}

body{
background:#ffffff;
overflow-x:hidden;
}

/* NAVBAR */

.navbar{
transition:.4s;
padding:18px 0;
}

.navbar.scrolled{
background:#111827;
box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.navbar-brand{
font-size:30px;
font-weight:800;
color:#fff!important;
}

.nav-link{
color:#fff!important;
margin-left:15px;
font-weight:500;
transition:.3s;
}

.nav-link:hover{
color:#0d6efd!important;
}

/* HERO */

.hero{

height:100vh;

background:

linear-gradient(rgba(0,0,0,.65),
rgba(0,0,0,.65)),

url('../assets/images/gym-banner.jpg');

background-size:cover;
background-position:center;

display:flex;
align-items:center;

color:white;

position:relative;

overflow:hidden;

}

.hero::before{

content:'';

position:absolute;

width:500px;
height:500px;

background:#0d6efd;

filter:blur(180px);

top:-150px;
right:-120px;

opacity:.45;

}

.hero h1{

font-size:70px;

font-weight:800;

line-height:1.1;

}

.hero span{

color:#0d6efd;

}

.hero p{

font-size:20px;

margin:25px 0;

max-width:650px;

}

.hero-btn{

padding:15px 35px;

border-radius:50px;

font-size:18px;

font-weight:600;

margin-right:15px;

transition:.4s;

}

.hero-btn:hover{

transform:translateY(-4px);

}

.play-btn{

width:70px;

height:70px;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

background:white;

color:#0d6efd;

font-size:28px;

text-decoration:none;

transition:.4s;

}

.play-btn:hover{

transform:scale(1.1);

}

/* FLOATING CARD */

.floating-card{

background:white;

padding:30px;

border-radius:25px;

box-shadow:0 20px 45px rgba(0,0,0,.15);

position:absolute;

bottom:60px;

right:60px;

width:330px;

animation:float 3s infinite;

}

@keyframes float{

50%{
transform:translateY(-15px);
}

}

/* STATS */

.stats{

padding:90px 0;

background:#f8fafc;

}

.stat-card{

background:white;

padding:35px;

text-align:center;

border-radius:25px;

box-shadow:0 15px 35px rgba(0,0,0,.08);

transition:.4s;

height:100%;

}

.stat-card:hover{

transform:translateY(-10px);

}

.stat-card i{

font-size:45px;

color:#0d6efd;

margin-bottom:20px;

}

.stat-card h2{

font-weight:800;

font-size:42px;

}

.stat-card p{

color:#666;

}

/* WHY */

.section-title{

font-size:45px;

font-weight:800;

margin-bottom:15px;

}

.section-sub{

color:#666;

max-width:700px;

margin:auto;

}

.feature{

padding:35px;

border-radius:20px;

transition:.4s;

background:white;

box-shadow:0 10px 30px rgba(0,0,0,.08);

height:100%;

}

.feature:hover{

background:#0d6efd;

color:white;

transform:translateY(-10px);

}

.feature:hover p{

color:white;

}

.feature i{

font-size:50px;

margin-bottom:20px;

color:#0d6efd;

}

.feature:hover i{

color:white;

}

@media(max-width:992px){

.hero{

text-align:center;

}

.hero h1{

font-size:48px;

}

.floating-card{

display:none;

}

}

</style>

</head>

<body>

<!-- NAVIGATION -->

<nav
class="navbar navbar-expand-lg fixed-top">

<div class="container">




<div class="topbar d-flex align-items-center justify-content-between px-3">

    <!-- LEFT: Logo -->
    <div class="d-flex align-items-center">
        <img src="<?= $base ?>website/assets/images/FitPro Gym Logo.png" alt="Logo" style="height:40px; width:auto; margin-right:10px;">
        <a
class="navbar-brand"
href="#">
FitPro GYM
</a>
    </div>



<button
class="navbar-toggler bg-white"
data-bs-toggle="collapse"
data-bs-target="#menu">

<span
class="navbar-toggler-icon">
</span>

</button>

<div
class="collapse navbar-collapse"
id="menu">

<ul
class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="#">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="about.php">About</a>
</li>

<li class="nav-item">
<a class="nav-link" href="membership.php">Membership</a>
</li>

<li class="nav-item">
<a class="nav-link" href="trainers.php">Trainers</a>
</li>

<li class="nav-item">
<a class="nav-link" href="classes.php">Classes</a>
</li>

<li class="nav-item">
<a class="nav-link" href="gallery.php">Gallery</a>
</li>

<li class="nav-item">
<a class="nav-link" href="contact.php">Contact</a>
</li>

<li class="nav-item ms-3">

<a
href="login.php"
class="btn btn-primary rounded-pill px-4">

Member Login

</a>

</li>

</ul>

</div>

</div>

</nav>

<!-- HERO -->

<section class="hero">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-7">

<h1>

Transform Your

<span>Body</span>

Transform

Your Life

</h1>

<p>

Join Kenya's premier fitness destination with certified trainers, world-class equipment, flexible membership plans, and a supportive community dedicated to helping you reach your goals.

</p>

<a
href="membership.php"
class="btn btn-primary hero-btn">

Join Now

</a>

<a
href="about.php"
class="btn btn-outline-light hero-btn">

Learn More

</a>

</div>

</div>

</div>

<div class="floating-card">

<h4 class="fw-bold">

🔥 Special Offer

</h4>

<p>

Register today and receive a free fitness assessment plus a personalised workout plan.

</p>

<a
href="register.php"
class="btn btn-success w-100">

Become a Member

</a>

</div>

</section>

<!-- LIVE STATS -->

<section class="stats">

<div class="container">

<div class="row g-4">

<div class="col-md-3">

<div class="stat-card">

<i class="fa fa-users"></i>

<h2><?= $totalMembers ?>+</h2>

<p>Happy Members</p>

</div>

</div>

<div class="col-md-3">

<div class="stat-card">

<i class="fa fa-dumbbell"></i>

<h2><?= $totalTrainers ?></h2>

<p>Professional Trainers</p>

</div>

</div>

<div class="col-md-3">

<div class="stat-card">

<i class="fa fa-award"></i>

<h2><?= $totalPlans ?></h2>

<p>Membership Plans</p>

</div>

</div>

<div class="col-md-3">

<div class="stat-card">

<i class="fa fa-calendar-check"></i>

<h2><?= $totalClasses ?></h2>

<p>Fitness Classes</p>

</div>

</div>

</div>

</div>

</section>

<!-- WHY CHOOSE US -->

<section class="py-5">

<div class="container">

<div class="text-center mb-5">

<h2 class="section-title">

Why Choose FitPro Gym

</h2>

<p class="section-sub">

Achieve your fitness goals with cutting-edge equipment, experienced coaches, and a motivating community.

</p>

</div>

<div class="row g-4">

<div class="col-md-4">

<div class="feature">

<i class="fa fa-dumbbell"></i>

<h4>Modern Equipment</h4>

<p>Train using premium strength and cardio equipment in a clean, spacious environment.</p>

</div>

</div>

<div class="col-md-4">

<div class="feature">

<i class="fa fa-user-tie"></i>

<h4>Expert Trainers</h4>

<p>Certified professionals provide personalised coaching to help you progress safely and effectively.</p>

</div>

</div>

<div class="col-md-4">

<div class="feature">

<i class="fa fa-heart-pulse"></i>

<h4>Healthy Lifestyle</h4>

<p>Fitness guidance, nutrition support, and a welcoming community to keep you motivated.</p>

</div>

</div>

</div>

</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
window.addEventListener('scroll',function(){
const nav=document.querySelector('.navbar');
nav.classList.toggle('scrolled',window.scrollY>50);
});
</script>

</body>
</html>