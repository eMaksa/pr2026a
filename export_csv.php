<?php
require_once 'db.php';

$filename = 'students_' . date('Y-m-d') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// чтобы Excel нормально открыл UTF-8
echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');

// заголовки
fputcsv($output, ['ID', 'Username', 'Email', 'Faculty'], ';');

// запрос
$sql = "
    SELECT u.id, u.username, u.email, f.name AS faculty
    FROM users u
    LEFT JOIN faculties f ON u.faculty_id = f.id
";

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['username'],
            $row['email'],
            $row['faculty']
        ], ';');
    }
}

fclose($output);
exit;
