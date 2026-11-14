<?php

require "auth.php";

include "../db.php";

$sql = $conn->prepare(
    "SELECT * FROM users WHERE role = 'patient'
     ORDER BY id DESC"
);

$sql->execute();

$patients = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Patients List</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="dashboard-content">

    <h1>Patients Management</h1>

    <a href="dashboard.php">Back to Dashboard</a>

    <h3>Total Patients: <?php echo count($patients); ?></h3>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($patients as $patient): ?>

                <tr>

                    <td><?php echo $patient["id"]; ?></td>

                    <td>
                        <?php echo htmlspecialchars($patient["full_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($patient["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($patient["phone"] ?? ""); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($patient["gender"] ?? ""); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($patient["date_of_birth"] ?? ""); ?>
                    </td>

                    <td>

                        <a href="edit-user.php?id=<?php echo $patient['id']; ?>&type=patient">
                            Edit
                        </a>

                        <form method="POST" action="delete-user.php"
                              onsubmit="return confirm('Delete this patient?');">

                            <input type="hidden" name="id"
                                   value="<?php echo $patient['id']; ?>">

                            <input type="hidden" name="type" value="patient">

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