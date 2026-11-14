<?php

include "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check empty fields
    if (
        empty($full_name) ||
        empty($email) ||
        empty($password) ||
        empty($confirm_password)
    ) {

        $message = "All fields are required.";
        $messageType = "error";

    }

    // Validate email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email.";
        $messageType = "error";

    }

    // Check password length
    elseif (strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";
        $messageType = "error";

    }

    // Compare passwords
    elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";
        $messageType = "error";

    }

    else {

        // Check whether email already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->execute([$email]);

        if ($check->rowCount() > 0) {

            $message = "Email already registered.";
            $messageType = "error";

        }

        else {

            // Encrypt password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert user
            $sql = $conn->prepare(
                "INSERT INTO users (full_name, email, password)
                 VALUES (?, ?, ?)"
            );

            $sql->execute([
                $full_name,
                $email,
                $hashed_password
            ]);

            $message = "Registration successful! You can now login.";
            $messageType = "success";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hospital - Registration</title>

    <link rel="stylesheet" href="css/style.css">

    <script src="js/script.js" defer></script>

</head>

<body>

    <div class="container">

        <div class="form-box">

            <h1>Hospital Management</h1>

            <h2>Create Account</h2>

            <p class="subtitle">
                Register to access the hospital system.
            </p>

            <?php if (!empty($message)): ?>

                <div class="message <?php echo $messageType; ?>">

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>

            <form method="POST" action="register.php" id="registerForm">

                <div class="input-group">

                    <label>Full Name</label>

                    <input
                        type="text"
                        name="full_name"
                        id="full_name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>

                <div class="input-group">

    <label>Register As</label>

    <select name="role" id="role" required>

        <option value="">Select Account Type</option>

        <option value="doctor">Doctor</option>

        <option value="patient">Patient</option>

    </select>

</div>

                <div class="input-group">

                    <label>Email Address</label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Create password"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="confirm_password"
                        id="confirm_password"
                        placeholder="Confirm password"
                        required
                    >

                </div>

                <div class="input-group">

    <label>Phone</label>

    <input type="text" name="phone" placeholder="Phone number">

</div>

<div class="input-group">

    <label>Address</label>

    <input type="text" name="address" placeholder="Your address">

</div>

<div class="input-group">

    <label>Gender</label>

    <select name="gender">

        <option value="">Select Gender</option>

        <option value="Male">Male</option>

        <option value="Female">Female</option>

        <option value="Other">Other</option>

    </select>

</div>

<div class="input-group">

    <label>Date of Birth</label>

    <input type="date" name="date_of_birth">

</div>

<div class="input-group">

    <label>Specialization (Doctors only)</label>

    <input type="text" name="specialization">

</div>

<div class="input-group">

    <label>License Number (Doctors only)</label>

    <input type="text" name="license_number">

</div>

                <button type="submit" name="register">
                    Register
                </button>

            </form>

            <p class="bottom-text">

                Already have an account?

                <a href="login.php">Login here</a>

            </p>

        </div>

    </div>

</body>

</html>