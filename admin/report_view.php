<?php
// View Garissa County Report

require_once "../config/db.php";
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET["id"] ?? 0);
$county = "Garissa";

// Load Garissa County report only
$stmt = $conn->prepare("SELECT * FROM reports WHERE id=? AND county=?");
$stmt->bind_param("is", $id, $county);
$stmt->execute();
$report = $stmt->get_result()->fetch_assoc();

if (!$report) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Garissa County Report Details</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<header class="topbar">
    <div class="container topbar__inner">
        <a class="brand" href="dashboard.php">
            <span class="brand__logo"></span>
            <span>Garissa County Report Details</span>
        </a>
    </div>
</header>

<main class="container">

<section class="hero">

    <h2>Garissa County Report #<?= (int)$report["id"] ?></h2>

    <div class="card">

        <p>
            <strong>Location:</strong>
            <?= htmlspecialchars($report["area"]) ?>, Garissa County
        </p>

        <p>
            <strong>Issue:</strong>
            <?= htmlspecialchars($report["issue_type"]) ?>
        </p>

        <p>
            <strong>Status:</strong>
            <?= htmlspecialchars($report["status"]) ?>
        </p>

        <p>
            <strong>Description:</strong><br>
            <?= nl2br(htmlspecialchars($report["description"])) ?>
        </p>

        <?php if (!empty($report["photo"])): ?>
            <div style="margin-top:12px;">
                <img
                    src="../uploads/<?= htmlspecialchars($report["photo"]) ?>"
                    style="width:100%; max-height:300px; object-fit:cover;"
                    alt="Garissa County water shortage report photo"
                >
            </div>
        <?php endif; ?>

        <div class="btnrow">

            <a class="btn" href="report_action.php?id=<?= $report["id"] ?>&action=verify">
                Verify
            </a>

            <a class="btn" href="report_action.php?id=<?= $report["id"] ?>&action=resolve">
                Resolve
            </a>

            <a
                class="btn"
                href="report_action.php?id=<?= $report["id"] ?>&action=delete"
                onclick="return confirm('Delete this Garissa County report?');"
            >
                Delete
            </a>

            <a class="btn" href="dashboard.php">
                Back
            </a>

        </div>

    </div>

</section>

</main>

</body>
</html>