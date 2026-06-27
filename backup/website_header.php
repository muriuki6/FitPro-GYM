<?php
$pageTitle = $pageTitle ?? 'FitPro Gym';
$pageDescription = $pageDescription ?? 'Premium fitness center with modern equipment, expert trainers, flexible memberships, and member tracking.';
$basePath = $basePath ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta name="keywords" content="FitPro Gym, gym, fitness, trainers, membership, classes">
<meta name="author" content="FitPro Gym">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta property="og:type" content="website">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link rel="icon" href="<?= $basePath ?>assets/images/favicon.svg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $basePath ?>assets/css/website.css">
</head>
<body>

