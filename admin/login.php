<?php
// Garissa County Admin Login

require_once "../config/db.php";
session_start();

$err = "";

// Login
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $pass  = $_POST["password"] ?? "";

    /*
    Garissa County admins only
    Assumes users table has county column

    ALTER TABLE users ADD county VARCHAR(100) DEFAULT 'Garissa';
    */

    $county = "Garissa";

    $stmt = $conn->prepare("
        SELECT id, name, password_hash
        FROM users
        WHERE email = ?
        AND county = ?
        LIMIT 1
    ");

    $stmt->bind_param("ss", $email, $county);
    $stmt->execute();

    $u = $stmt->get_result()->fetch_assoc();

    if ($u && password_verify($pass, $u["password_hash"])) {

        $_SESSION["admin_id"]   = $u["id"];
        $_SESSION["admin_name"] = $u["name"];
        $_SESSION["county"]     = "Garissa";

        header("Location: dashboard.php");
        exit;

    } else {
        $err = "Wrong email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Garissa County Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<header class="topbar">
    <div class="container topbar__inner">

        <a class="brand" href="../index.php">
            <span class="brand__logo"></span>
            <span>MajiAlert - Garissa County</span>
        </a>

    </div>
</header>

<main class="container">

<section class="hero">

    <h2>Garissa County Admin Login</h2>

    <?php if($err): ?>
        <div class="card" style="border-color: rgba(255,92,108,.5); background: rgba(255,92,108,.10);">
            <strong><?= htmlspecialchars($err) ?></strong>
        </div>
    <?php endif; ?>

    <form class="card" method="POST" style="max-width:520px;">

        <label>Email</label>
        <input
            type="email"
            name="email"
            required
            placeholder="admin@garissa.majialert.local"
        >

        <div style="height:10px;"></div>

        <label>Password</label>
        <input
            type="password"
            name="password"
            required
            placeholder="Enter password"
        >

        <div class="btnrow">

            <button class="btn btn--primary" type="submit">
                <span class="btn__dot"></span>
                Login
            </button>

            <a class="btn" href="../index.php">Back</a>

        </div>

        <p class="lead" style="margin-top:10px; font-size:13px;">
            Garissa County water management administrator access only.
        </p>

        <p class="lead" style="margin-top:6px; font-size:13px;">
            Default: admin@garissa.majialert.local / Admin12345
        </p>

    </form>

</section>

</main>

</body>
</html>