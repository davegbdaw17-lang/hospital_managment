<?php

require "auth.php";

include "../db.php";

$sql = $conn->prepare(
    "SELECT * FROM users WHERE role = 'doctor'
     ORDER BY id DESC"
);

$sql->execute();

$doctors = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Doctors List</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="dashboard-content">

    <h1>Doctors Management</h1>

    <a href="dashboard.php">Back to Dashboard</a>

    <h3>Total Doctors: <?php echo count($doctors); ?></h3>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>License</th>
                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($doctors as $doctor): ?>

                <tr>

                    <td><?php echo $doctor["id"]; ?></td>

                    <td>
                        <?php echo htmlspecialchars($doctor["full_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($doctor["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($doctor["phone"] ?? ""); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($doctor["specialization"] ?? ""); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($doctor["license_number"] ?? ""); ?>
                    </td>

                    <td>

                        <a href="edit-user.php?id=<?php echo $doctor['id']; ?>&type=doctor">
                            Edit
                        </a>

                        <form method="POST" action="delete-user.php"
                              onsubmit="return confirm('Delete this doctor?');">

                            <input type="hidden" name="id"
                                   value="<?php echo $doctor['id']; ?>">

                            <input type="hidden" name="type" value="doctor">

                            <button type="submit">Delete</button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>

</html>