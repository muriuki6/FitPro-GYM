<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>FitPro Gym Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<?php
$base = str_contains($_SERVER['PHP_SELF'], '/admin/')
      || str_contains($_SERVER['PHP_SELF'], '/trainer/')
      || str_contains($_SERVER['PHP_SELF'], '/member/')
      ? '../'
      : '';
?>

<link rel="stylesheet"
href="<?= $base ?>assets/css/style.css">

</head>

<body>