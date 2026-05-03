<?php
// Garissa County Report Actions

require_once "../config/db.php";
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET["id"] ?? 0);
$action = $_GET["action"] ?? "";
$county = "Garissa";

/*
This assumes reports table has county column

ALTER TABLE reports ADD county VARCHAR(100) DEFAULT 'Garissa';
*/

if ($id > 0) {

    // Verify Garissa report only
    if ($action === "verify") {
        $stmt = $conn->prepare("
            UPDATE reports 
            SET status='Verified' 
            WHERE id=? AND county=?
        ");
        $stmt->bind_param("is", $id, $county);
        $stmt->execute();
    }

    // Resolve Garissa report only
    if ($action === "resolve") {
        $stmt = $conn->prepare("
            UPDATE reports 
            SET status='Resolved' 
            WHERE id=? AND county=?
        ");
        $stmt->bind_param("is", $id, $county);
        $stmt->execute();
    }

    // Delete Garissa report only
    if ($action === "delete") {
        $stmt = $conn->prepare("
            DELETE FROM reports 
            WHERE id=? AND county=?
        ");
        $stmt->bind_param("is", $id, $county);
        $stmt->execute();
    }
}

// Back to Garissa dashboard
header("Location: dashboard.php");
exit;
?>