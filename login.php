<?php

session_start();

include "db.php";

$message = "";
$messageType = "";

if (isset($_GET["registered"])) {

    $message = "Registration successful! Please login.";
    $messageType = "success";

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";
        $messageType = "error";

    }

    else {

        // Find user by email
        $sql = $conn->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $sql->execute([$email]);

        $user = $sql->fetch(PDO::FETCH_ASSOC);

        // Check password
        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["role"] = $user["role"];

            $message = "Welcome, " .
                htmlspecialchars($user["full_name"]) .
                "! Login successful.";

            $messageType = "success";

        }

        else {

            $message = "Invalid email or password.";
            $messageType = "error";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hospital - Login</title>

    <link rel="stylesheet" href="css/style.css">

    <script src="js/script.js" defer></script>

</head>

<body>

    <div class="container">

        <div class="form-box">

            <h1>Hospital Management</h1>

            <h2>Welcome Back</h2>

            <p class="subtitle">
                Login to access your account.
            </p>

            <?php if (!empty($message)): ?>

                <div class="message <?php echo $messageType; ?>">

                    <?php echo $message; ?>

                </div>

            <?php endif; ?>

            <form method="POST" action="login.php" id="loginForm">

                <div class="input-group">

                    <label>Email Address</label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                </div>

                <button type="submit" name="login">
                    Login
                </button>

            </form>

            <p class="bottom-text">

                Don't have an account?

                <a href="register.php">Register here</a>

            </p>

        </div>

    </div>

</body>

</html>