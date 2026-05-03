<?php 
// Garissa County Admin Dashboard

require_once "../config/db.php";
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$status = trim($_GET["status"] ?? "");

/*
IMPORTANT:
This assumes your reports table has:
county column

If not, add it:
ALTER TABLE reports ADD county VARCHAR(100) NOT NULL DEFAULT 'Garissa';
*/

$county = "Garissa";

// Load Garissa County reports only
$sql = "SELECT * FROM reports WHERE county='$county' ";

if ($status !== "" && in_array($status, ["Pending","Verified","Resolved"])) {
    $sql .= "AND status='".$conn->real_escape_string($status)."' ";
}

$sql .= "ORDER BY created_at DESC LIMIT 300";

$res = $conn->query($sql);

// Counts for Garissa only
$counts = [
    "Pending" => 0,
    "Verified" => 0,
    "Resolved" => 0
];

$cq = $conn->query("
    SELECT status, COUNT(*) c 
    FROM reports 
    WHERE county='$county'
    GROUP BY status
");

while ($r = $cq->fetch_assoc()) {
    $counts[$r["status"]] = (int)$r["c"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Garissa County Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="topbar">
    <div class="container topbar__inner">

        <a class="brand" href="dashboard.php">
            <span class="brand__logo"></span>
            <span>Garissa County Dashboard</span>
        </a>

        <nav class="nav">
            <a class="<?= $status===""?"active":"" ?>" href="dashboard.php">All</a>
            <a class="<?= $status==="Pending"?"active":"" ?>" href="dashboard.php?status=Pending">Pending</a>
            <a class="<?= $status==="Verified"?"active":"" ?>" href="dashboard.php?status=Verified">Verified</a>
            <a class="<?= $status==="Resolved"?"active":"" ?>" href="dashboard.php?status=Resolved">Resolved</a>
            <a href="logout.php">Logout</a>
        </nav>

    </div>
</header>

<main class="container">

<section class="hero">

    <h2>Hello, <?= htmlspecialchars($_SESSION["admin_name"]) ?></h2>

    <p class="lead">
        Manage water shortage reports for Garissa County.
    </p>

    <div class="grid" style="grid-template-columns: repeat(3, minmax(0,1fr));">

        <div class="card">
            <h3>Pending</h3>
            <p><?= $counts["Pending"] ?></p>
        </div>

        <div class="card">
            <h3>Verified</h3>
            <p><?= $counts["Verified"] ?></p>
        </div>

        <div class="card">
            <h3>Resolved</h3>
            <p><?= $counts["Resolved"] ?></p>
        </div>

    </div>

    <div class="card" style="margin-top:14px; overflow:auto;">

        <table style="width:100%; border-collapse:collapse;">

            <thead>
                <tr style="text-align:left; color: var(--muted);">
                    <th style="padding:10px; border-bottom:1px solid var(--line);">ID</th>
                    <th style="padding:10px; border-bottom:1px solid var(--line);">Location</th>
                    <th style="padding:10px; border-bottom:1px solid var(--line);">Issue</th>
                    <th style="padding:10px; border-bottom:1px solid var(--line);">Status</th>
                    <th style="padding:10px; border-bottom:1px solid var(--line);">Action</th>
                </tr>
            </thead>

            <tbody>

            <?php while($r = $res->fetch_assoc()): ?>

                <tr>

                    <td style="padding:10px; border-bottom:1px solid var(--line);">
                        #<?= (int)$r["id"] ?>
                    </td>

                    <td style="padding:10px; border-bottom:1px solid var(--line);">
                        <strong><?= htmlspecialchars($r["area"]) ?></strong><br>
                        Garissa County
                    </td>

                    <td style="padding:10px; border-bottom:1px solid var(--line);">
                        <?= htmlspecialchars($r["issue_type"]) ?>
                    </td>

                    <td style="padding:10px; border-bottom:1px solid var(--line);">
                        <?= htmlspecialchars($r["status"]) ?>
                    </td>

                    <td style="padding:10px; border-bottom:1px solid var(--line);">
                        <a href="view.php?id=<?= $r["id"] ?>">View</a>
                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</section>

</main>

</body>
</html>