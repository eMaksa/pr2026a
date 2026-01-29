<?php
require_once 'db.php';

// Выбираем случайного студента с информацией о факультете и статусе
$sql = "
    SELECT 
        u.username, 
        u.email, 
        f.name AS faculty,
        s.name AS status
    FROM users u
    LEFT JOIN faculties f ON u.faculty_id = f.id
    LEFT JOIN intern_status s ON u.status_id = s.id
    ORDER BY RAND()
    LIMIT 1
";

$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "Нет студентов";
    exit;
}

$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Случайный студент дня</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }
        .card {
            background: #fff;
            padding: 25px;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>🎓 Студент дня</h2>
    <p><strong>Имя:</strong> <?= htmlspecialchars($student['username']) ?></p>
    <p><strong>Факультет:</strong> <?= htmlspecialchars($student['faculty'] ?? '—') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
    <p><strong>Статус:</strong> <?= htmlspecialchars($student['status'] ?? '—') ?></p>
</div>

</body>
</html>
