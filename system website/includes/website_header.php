<?php
/**
 * FitPro Gym - Website Header
 * Premium modern header with Bootstrap 5
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FitPro Gym - Premium Fitness Center with Expert Trainers & State-of-the-art Equipment">
    <meta name="keywords" content="gym, fitness, trainers, classes, membership">
    <meta name="author" content="FitPro Gym Management">
    <meta property="og:title" content="FitPro Gym - Your Premium Fitness Center">
    <meta property="og:description" content="Join FitPro Gym for premium fitness training and facilities">
    <meta property="og:type" content="website">
    
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . " | " : ""; ?>FitPro Gym</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Website CSS -->
    <link rel="stylesheet" href="<?php echo isset($basePath) ? $basePath : ''; ?>assets/css/website-style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo isset($basePath) ? $basePath : ''; ?>system website/assets/images/FitPro Gym Logo.png">
</head>
<body>
