<?php

require_once 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все пользователи</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #eaeaea;
        }
    </style>
</head>
<body>

<h2>Список пользователей</h2>

<?php
if ($result->num_rows === 0) {
    echo "<p>Пользователей пока нет</p>";
} else {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>

</body>
</html>