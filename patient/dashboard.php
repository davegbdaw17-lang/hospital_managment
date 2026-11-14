<?php

session_start();

// if (
//     !isset($_SESSION["user_id"]) ||
//     $_SESSION["role"] !== "patient"
// ) {
//     header("Location: ../login.php");
//     exit();
// }


$role = $_POST["role"] ?? "";

$phone = trim($_POST["phone"] ?? "");
$address = trim($_POST["address"] ?? "");
$gender = $_POST["gender"] ?? null;
$date_of_birth = $_POST["date_of_birth"] ?: null;

$specialization = trim($_POST["specialization"] ?? "");
$license_number = trim($_POST["license_number"] ?? "");

if (!in_array($role, ["doctor", "patient"], true)) {

    die("Invalid account type.");

}

if ($role === "patient") {

    $specialization = null;
    $license_number = null;

}

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql = $conn->prepare(
    "INSERT INTO users
    (full_name, email, password, role, phone, address,
     gender, date_of_birth, specialization, license_number)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$sql->execute([
    $full_name,
    $email,
    $hashed_password,
    $role,
    $phone,
    $address,
    $gender,
    $date_of_birth,
    $specialization,
    $license_number
]);

?>

<h1>Patient Dashboard</h1>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION["full_name"]); ?></h2>

<p>This is your patient dashboard.</p>

<a href="../logout.php">Logout</a>