<?php
// MajiAlert Garissa County Core Functions

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ===================================
   Escape Output (Security)
=================================== */
function e($string){
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/* ===================================
   System Constants
=================================== */
define("SYSTEM_NAME", "MajiAlert Garissa");
define("SYSTEM_COUNTY", "Garissa County");

/* ===================================
   Check Admin Login
=================================== */
function is_admin_logged_in(){
    return isset($_SESSION["admin_id"]);
}

/* ===================================
   Get Admin Name
=================================== */
function admin_name(){
    return $_SESSION["admin_name"] ?? "Administrator";
}

/* ===================================
   Force Login
=================================== */
function require_admin(){

    if (!is_admin_logged_in()) {
        header("Location: /majialert/admin/login.php");
        exit;
    }
}

/* ===================================
   County Protection
=================================== */
function require_garissa_access(){

    if (!isset($_SESSION["county"])) {
        $_SESSION["county"] = "Garissa";
    }

    if ($_SESSION["county"] !== "Garissa") {
        session_destroy();
        header("Location: /majialert/admin/login.php");
        exit;
    }
}

/* ===================================
   Status Badge HTML
=================================== */
function report_status_badge($status){

    if ($status === "Pending") {
        return '<span class="badge badge-pending">Pending</span>';
    }

    if ($status === "Verified") {
        return '<span class="badge badge-verified">Verified</span>';
    }

    if ($status === "Resolved") {
        return '<span class="badge badge-resolved">Resolved</span>';
    }

    return '<span class="badge">'.$status.'</span>';
}

/* ===================================
   Greeting Message
=================================== */
function dashboard_greeting(){

    $hour = date("H");

    if ($hour < 12) {
        return "Good Morning";
    }

    if ($hour < 17) {
        return "Good Afternoon";
    }

    return "Good Evening";
}

/* ===================================
   Footer Year
=================================== */
function current_year(){
    return date("Y");
}
?>