<?php


$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

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