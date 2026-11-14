<?php

include "db.php";

// Admin account details
$full_name = "Hospital Administrator";
$email = "admin@hospital.com";
$password = "Admin@12345";

// Check existing admin
$check = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check->execute([$email]);

if ($check->fetch()) {

    die("Admin account already exists.");

}

// Hash password
$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);

// Create admin
$sql = $conn->prepare(
    "INSERT INTO users
    (full_name, email, password, role)
    VALUES (?, ?, ?, 'admin')"
);

$sql->execute([
    $full_name,
    $email,
    $hashed_password
]);

echo "Admin account created successfully.";

?>