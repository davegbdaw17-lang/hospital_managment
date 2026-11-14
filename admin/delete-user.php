<?php

require "auth.php";

include "../db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$type = $_POST["type"] ?? "";

if (!$id || !in_array($type, ["doctor", "patient"], true)) {
    die("Invalid user.");
}

// Delete only the selected role
$sql = $conn->prepare(
    "DELETE FROM users WHERE id = ? AND role = ?"
);

$sql->execute([$id, $type]);

// Return to the correct list
if ($type === "doctor") {

    header("Location: doctors.php");

} else {

    header("Location: patients.php");

}

exit();

?>