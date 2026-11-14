<?php

require "auth.php";

include "../db.php";

// Count doctors
$doctorCount = $conn->query(
    "SELECT COUNT(*) FROM users WHERE role = 'doctor'"
)->fetchColumn();

// Count patients
$patientCount = $conn->query(
    "SELECT COUNT(*) FROM users WHERE role = 'patient'"
)->fetchColumn();

// Count total users
$totalCount = $conn->query(
    "SELECT COUNT(*) FROM users
     WHERE role IN ('doctor', 'patient')"
)->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="dashboard">

    <aside class="sidebar">

        <h2>Hospital Admin</h2>

        <a href="dashboard.php">Dashboard</a>

        <a href="doctors.php">Doctors</a>

        <a href="patients.php">Patients</a>

        <a href="../logout.php">Logout</a>

    </aside>

    <main class="dashboard-content">

        <h1>Admin Dashboard</h1>

        <p>
            Welcome,
            <?php echo htmlspecialchars($_SESSION["full_name"]); ?>
        </p>

        <div class="dashboard-cards">

            <div class="stat-card">

                <h3>Total Doctors</h3>

                <h1><?php echo $doctorCount; ?></h1>

                <a href="doctors.php">View Doctors</a>

            </div>

            <div class="stat-card">

                <h3>Total Patients</h3>

                <h1><?php echo $patientCount; ?></h1>

                <a href="patients.php">View Patients</a>

            </div>

            <div class="stat-card">

                <h3>Total Registered Users</h3>

                <h1><?php echo $totalCount; ?></h1>

            </div>

        </div>

    </main>

</div>

</body>

</html>