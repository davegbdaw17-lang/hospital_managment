<?php

session_start();

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "doctor"
) {
    header("Location: ../login.php");
    exit();
}

?>

<h1>Doctor Dashboard</h1>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION["full_name"]); ?></h2>

<p>This is your doctor dashboard.</p>

<a href="../logout.php">Logout</a>