<?php
// Public Reports - Garissa County Only

require_once "includes/header.php";
require_once "config/db.php";

$county = "Garissa";
$status = trim($_GET["status"] ?? "Verified");

if (!in_array($status, ["Verified", "Resolved"])) {
    $status = "Verified";
}

$sql = "
    SELECT * 
    FROM reports 
    WHERE county = ? 
    AND status = ?
    ORDER BY created_at DESC 
    LIMIT 200
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $county, $status);
$stmt->execute();
$res = $stmt->get_result();
?>

<section class="hero hero--reports">

    <div class="hero__badge">
        💧 Garissa County Public Water Reports
    </div>

    <h2>Verified Water Reports</h2>

    <p class="lead">
        View confirmed water shortage reports from communities across
        <strong>Garissa County</strong>.
    </p>

    <!-- Filter -->
    <form class="card" method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:end;">

        <div style="flex:1; min-width:220px;">
            <label>County</label>
            <input value="Garissa County" readonly>
        </div>

        <div style="min-width:200px;">
            <label>Status</label>
            <select name="status">
                <option value="Verified" <?= $status==="Verified" ? "selected" : "" ?>>
                    Verified
                </option>
                <option value="Resolved" <?= $status==="Resolved" ? "selected" : "" ?>>
                    Resolved
                </option>
            </select>
        </div>

        <button class="btn btn--primary" type="submit">
            <span class="btn__dot"></span>
            Filter Reports
        </button>

        <a class="btn" href="reports.php">Reset</a>

    </form>

    <!-- Reports List -->
    <div class="grid" style="grid-template-columns: repeat(2, minmax(0,1fr)); margin-top:14px;">

        <?php if($res->num_rows === 0): ?>

            <div class="card" style="grid-column:1/-1;">
                <h3>No <?= htmlspecialchars($status) ?> Reports Yet</h3>
                <p class="lead" style="margin:0;">
                    There are currently no <?= htmlspecialchars(strtolower($status)) ?>
                    water reports for Garissa County.
                </p>
            </div>

        <?php endif; ?>

        <?php while($r = $res->fetch_assoc()): ?>

            <div class="card card--report">

                <h3 style="margin:0 0 8px;">
                    <?= htmlspecialchars($r["issue_type"]) ?> —
                    <?= htmlspecialchars($r["area"]) ?>
                </h3>

                <p style="margin:0; color:var(--muted);">
                    Garissa County • <?= htmlspecialchars($r["sub_county"]) ?><br>

                    Status:
                    <strong class="badge badge-<?= strtolower(htmlspecialchars($r["status"])) ?>">
                        <?= htmlspecialchars($r["status"]) ?>
                    </strong>
                    <br>

                    Submitted:
                    <?= date("M d, Y H:i", strtotime($r["created_at"])) ?>
                </p>

                <p style="margin-top:10px; color:var(--muted); line-height:1.6;">
                    <?= nl2br(htmlspecialchars($r["description"])) ?>
                </p>

                <?php if(!empty($r["photo"])): ?>
                    <div style="margin-top:12px; border-radius:16px; overflow:hidden; border:1px solid var(--line);">
                        <img
                            src="uploads/<?= htmlspecialchars($r["photo"]) ?>"
                            style="width:100%; display:block; max-height:260px; object-fit:cover;"
                            alt="Garissa County water report photo"
                        >
                    </div>
                <?php endif; ?>

            </div>

        <?php endwhile; ?>

    </div>

</section>

<?php
require_once "includes/footer.php";
?>