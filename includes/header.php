<?php
// Shared Header - MajiAlert Garissa County

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Active navigation helper */
function is_active($path){
    $current = basename($_SERVER["PHP_SELF"]);
    return ($current === $path) ? "active" : "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MajiAlert Garissa County</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap">

</head>

<body>

<header class="topbar topbar--glass">

    <div class="container topbar__inner">

        <!-- Brand -->
        <a class="brand brand--premium" href="index.php">

            <span class="brand__logo"></span>

            <span class="brand__text">
                <strong>MajiAlert</strong>
                <small>Garissa County</small>
            </span>

        </a>

        <!-- Navigation -->
        <nav class="nav nav--premium">

            <a class="<?= is_active('index.php') ?>" href="index.php">
                Home
            </a>

            <a class="<?= is_active('report.php') ?>" href="report.php">
                Report Issue
            </a>

            <a class="<?= is_active('reports.php') ?>" href="reports.php">
                Public Reports
            </a>

            <a class="<?= is_active('about.php') ?>" href="about.php">
                About
            </a>

            <a class="btn btn--primary nav__admin" href="admin/login.php">
                Admin Portal
            </a>

        </nav>

    </div>

</header>

<!-- Hero Strip -->
<section class="county-strip">
    <div class="container county-strip__inner">

        <span class="county-dot"></span>

        <span>
            Smart Water Shortage Reporting & Tracking for
            <strong>Garissa County</strong>
        </span>

    </div>
</section>

<main class="container">