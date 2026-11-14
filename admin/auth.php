<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check login
if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");
    exit();

}

// Check admin role
if ($_SESSION["role"] !== "admin") {

    http_response_code(403);
    die("Access denied. Admin only.");

}

?>