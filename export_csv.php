<?php
require_once 'db.php';

$filename = 'students_' . date('Y-m-d') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// чтобы Excel нормально открыл UTF-8
echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');

// заголовки CSV
fputcsv($output, ['ID', 'Username', 'Email', 'Faculty', 'Status'], ';');

// запрос с JOIN статусом
$sql = "
    SELECT 
        u.id, 
        u.username, 
        u.email, 
        f.name AS faculty,
        s.name AS status
    FROM users u
    LEFT JOIN faculties f ON u.faculty_id = f.id
    LEFT JOIN intern_status s ON u.status_id = s.id
";

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['username'],
            $row['email'],
            $row['faculty'],
            $row['status']
        ], ';');
    }
}

fclose($output);
exit;
