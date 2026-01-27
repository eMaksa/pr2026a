<?php
require_once 'db.php';

$sql = "
    SELECT u.username, u.email, f.name AS faculty
    FROM users u
    LEFT JOIN faculties f ON u.faculty_id = f.id
    WHERE u.status_id = 1
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ищут практику</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>👀 Студенты, которые ищут практику</h2>

<table>
    <tr>
        <th>Имя</th>
        <th>Email</th>
        <th>Факультет</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['faculty'] ?? '—') ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Все уже с практикой 🎉</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
