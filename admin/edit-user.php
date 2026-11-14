<?php

require "auth.php";

include "../db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$type = $_GET["type"] ?? "";

if (!$id || !in_array($type, ["doctor", "patient"], true)) {
    die("Invalid request.");
}

// Find the selected user
$sql = $conn->prepare(
    "SELECT * FROM users WHERE id = ? AND role = ?"
);

$sql->execute([$id, $type]);

$user = $sql->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $gender = $_POST["gender"] ?: null;
    $date_of_birth = $_POST["date_of_birth"] ?: null;

    $specialization = $type === "doctor"
        ? trim($_POST["specialization"])
        : null;

    $license_number = $type === "doctor"
        ? trim($_POST["license_number"])
        : null;

    if (empty($full_name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Enter a valid name and email.";

    } else {

        // Check duplicate email
        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ? AND id != ?"
        );

        $check->execute([$email, $id]);

        if ($check->fetch()) {

            $message = "This email is already used.";

        } else {

            $update = $conn->prepare(
                "UPDATE users SET
                full_name = ?,
                email = ?,
                phone = ?,
                address = ?,
                gender = ?,
                date_of_birth = ?,
                specialization = ?,
                license_number = ?
                WHERE id = ? AND role = ?"
            );

            $update->execute([
                $full_name,
                $email,
                $phone,
                $address,
                $gender,
                $date_of_birth,
                $specialization,
                $license_number,
                $id,
                $type
            ]);

            header("Location: " . ($type === "doctor"
                ? "doctors.php"
                : "patients.php"));

            exit();

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Edit <?php echo ucfirst($type); ?></title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="form-box">

    <h1>Edit <?php echo ucfirst($type); ?></h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <label>Full Name</label>

        <input type="text" name="full_name"
               value="<?php echo htmlspecialchars($user['full_name']); ?>"
               required>

        <label>Email</label>

        <input type="email" name="email"
               value="<?php echo htmlspecialchars($user['email']); ?>"
               required>

        <label>Phone</label>

        <input type="text" name="phone"
               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

        <label>Address</label>

        <input type="text" name="address"
               value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">

        <label>Gender</label>

        <select name="gender">

            <option value="">Select gender</option>

            <option value="Male" <?php echo $user['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>

            <option value="Female" <?php echo $user['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>

            <option value="Other" <?php echo $user['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>

        </select>

        <label>Date of Birth</label>

        <input type="date" name="date_of_birth"
               value="<?php echo htmlspecialchars($user['date_of_birth'] ?? ''); ?>">

        <?php if ($type === "doctor"): ?>

            <label>Specialization</label>

            <input type="text" name="specialization"
                   value="<?php echo htmlspecialchars($user['specialization'] ?? ''); ?>">

            <label>License Number</label>

            <input type="text" name="license_number"
                   value="<?php echo htmlspecialchars($user['license_number'] ?? ''); ?>">

        <?php endif; ?>

        <button type="submit">Save Changes</button>

    </form>

    <p>
        <a href="<?php echo $type === 'doctor' ? 'doctors.php' : 'patients.php'; ?>">
            Cancel
        </a>
    </p>

</div>

</body>

</html>