<?php
// Load Header
require_once "includes/header.php";
?>

<section class="hero hero--home">

    <div class="hero__badge">
        💧 Garissa County Water Support Platform
    </div>

    <h2>
        Welcome to <span class="text-gradient">MajiAlert Garissa</span>
    </h2>

    <p class="lead">
        A smart and transparent water shortage reporting system built for
        <strong>Garissa County</strong>.
        Residents can report water problems in their area, while county
        administrators verify and update progress in real time.
    </p>

    <div class="btnrow">

        <a class="btn btn--primary" href="report.php">
            <span class="btn__dot"></span>
            Report Water Problem
        </a>

        <a class="btn" href="reports.php">
            View Public Reports
        </a>

    </div>

    <!-- Stats Cards -->
    <div class="grid">

        <div class="card card--feature">
            <h3>📍 Fast Local Reporting</h3>
            <p>
                Report shortages by sub-county, ward, village, or estate
                inside Garissa County.
            </p>
        </div>

        <div class="card card--feature">
            <h3>✔ Verified by Officials</h3>
            <p>
                County administrators review and verify genuine reports
                for trust and transparency.
            </p>
        </div>

        <div class="card card--feature">
            <h3>📊 Live Status Updates</h3>
            <p>
                Follow progress through
                <strong>Pending</strong>,
                <strong>Verified</strong>,
                and
                <strong>Resolved</strong>.
            </p>
        </div>

    </div>

    <!-- Why it matters -->
    <div class="card" style="margin-top:18px;">

        <h3>Why MajiAlert Matters</h3>

        <p class="lead" style="margin-bottom:10px;">
            Water shortages affect homes, schools, hospitals, and businesses.
            MajiAlert helps Garissa County respond faster using community reports.
        </p>

        <ul class="features">
            <li>Report dry taps quickly</li>
            <li>Track verified complaints</li>
            <li>Support faster county action</li>
            <li>Increase transparency</li>
            <li>Improve citizen engagement</li>
            <li>Better water planning</li>
        </ul>

    </div>

</section>

<?php
// Load Footer
require_once "includes/footer.php";
?>