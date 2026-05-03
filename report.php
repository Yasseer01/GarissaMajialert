<?php
require_once "includes/header.php";
require_once "config/db.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $county = "Garissa";
    $sub_county = trim($_POST["sub_county"] ?? "");
    $area = trim($_POST["area"] ?? "");
    $issue = trim($_POST["issue"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($sub_county === "" || $area === "" || $issue === "" || $description === "") {
        $error = "Please fill in all required fields.";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO reports 
            (county, sub_county, area, issue_type, description, status)
            VALUES (?, ?, ?, ?, ?, 'Pending')
        ");

        $stmt->bind_param(
            "sssss",
            $county,
            $sub_county,
            $area,
            $issue,
            $description
        );

        if ($stmt->execute()) {
            $success = "Your Garissa County water report has been submitted successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<section class="hero hero--report">

    <div class="hero__badge">
        💧 Garissa County Water Reporting
    </div>

    <h2>Report a Water Problem</h2>

    <p class="lead">
        Use this form to report water shortages, dirty water, burst pipes,
        or low pressure within <strong>Garissa County only</strong>.
    </p>

    <?php if ($success): ?>
        <div class="card alert-success">
            <strong><?= htmlspecialchars($success) ?></strong>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="card alert-error">
            <strong><?= htmlspecialchars($error) ?></strong>
        </div>
    <?php endif; ?>

    <form class="card" method="POST" style="max-width:720px;">

        <label>County</label>
        <input 
            type="text" 
            name="county" 
            value="Garissa County" 
            readonly
        >

        <div style="height:12px;"></div>

        <label>Sub-County</label>
        <select name="sub_county" required>
            <option value="">Select sub-county</option>
            <option value="Garissa Township">Garissa Township</option>
            <option value="Balambala">Balambala</option>
            <option value="Lagdera">Lagdera</option>
            <option value="Dadaab">Dadaab</option>
            <option value="Fafi">Fafi</option>
            <option value="Ijara">Ijara</option>
        </select>

        <div style="height:12px;"></div>

        <label>Area / Ward / Village / Estate</label>
        <input 
            type="text" 
            name="area" 
            required 
            placeholder="Example: Bulla Iftin, Township, Modika, Dadaab"
        >

        <div style="height:12px;"></div>

        <label>Issue Type</label>
        <select name="issue" required>
            <option value="">Select issue type</option>
            <option value="No water">No water</option>
            <option value="Dirty water">Dirty water</option>
            <option value="Burst pipe">Burst pipe</option>
            <option value="Low pressure">Low pressure</option>
            <option value="Water rationing issue">Water rationing issue</option>
            <option value="Delayed water supply">Delayed water supply</option>
        </select>

        <div style="height:12px;"></div>

        <label>Description</label>
        <textarea 
            name="description" 
            required 
            rows="5"
            placeholder="Describe the problem clearly. Example: No water in the area for 3 days."
        ></textarea>

        <div class="btnrow">

            <button class="btn btn--primary" type="submit">
                <span class="btn__dot"></span>
                Submit Report
            </button>

            <a class="btn" href="reports.php">
                View Reports
            </a>

        </div>

    </form>

</section>

<?php
require_once "includes/footer.php";
?>