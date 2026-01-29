<?php
require_once 'db.php';
header('Content-Type: application/json');

$response = ['status' => 'success', 'message' => '', 'users' => []];

/* =======================
   Универсальная загрузка пользователей
======================= */
function loadUsers($conn)
{
    $sql = "
        SELECT
            users.id,
            users.username,
            users.email,
            users.gender_id,
            users.faculty_id,
            users.status_id,
            genders.name AS gender,
            faculties.name AS faculty,
            intern_status.name AS status
        FROM users
        JOIN genders ON users.gender_id = genders.id
        JOIN faculties ON users.faculty_id = faculties.id
        LEFT JOIN intern_status ON users.status_id = intern_status.id
    ";

    $result = $conn->query($sql);
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users;
}

/* =======================
   GET — загрузка всех
======================= */
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $response['users'] = loadUsers($conn);
    echo json_encode($response);
    exit;
}

/* =======================
   POST
======================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id         = $_POST['id'] ?? '';
    $delete_id  = $_POST['delete_id'] ?? '';

    $username   = trim($_POST['username'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $gender_id  = $_POST['gender_id'] ?? '';
    $faculty_id = $_POST['faculty_id'] ?? '';
    $status_id  = $_POST['status_id'] ?? '';
    /* =======================
       SEARCH
    ======================= */
    if (!empty($_POST['action']) && $_POST['action'] === 'search') {

        $sql = "
            SELECT
                users.id,
                users.username,
                users.email,
                users.gender_id,
                users.faculty_id,
                users.status_id,
                genders.name AS gender,
                faculties.name AS faculty,
                intern_status.name AS status
            FROM users
            JOIN genders ON users.gender_id = genders.id
            JOIN faculties ON users.faculty_id = faculties.id
            LEFT JOIN intern_status ON users.status_id = intern_status.id
            WHERE 1=1
        ";

        $params = [];
        $types  = '';

        if ($username !== '') {
            $sql .= " AND users.username LIKE ?";
            $params[] = "%$username%";
            $types .= 's';
        }

        if ($email !== '') {
            $sql .= " AND users.email LIKE ?";
            $params[] = "%$email%";
            $types .= 's';
        }

        if ($gender_id !== '') {
            $sql .= " AND users.gender_id = ?";
            $params[] = $gender_id;
            $types .= 'i';
        }

        if ($faculty_id !== '') {
            $sql .= " AND users.faculty_id = ?";
            $params[] = $faculty_id;
            $types .= 'i';
        }

        if ($status_id !== '') {
            $sql .= " AND users.status_id = ?";
            $params[] = $status_id;
            $types .= 'i';
        }

        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $response['users'] = [];
        while ($row = $result->fetch_assoc()) {
            $response['users'][] = $row;
        }

        $response['message'] = 'Результаты поиска';
        echo json_encode($response);
        exit;
    }

    /* =======================
       DELETE
    ======================= */
    if (!empty($delete_id)) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();

        $response['message'] = 'Пользователь удалён';
        $response['users'] = loadUsers($conn);
        echo json_encode($response);
        exit;
    }

    /* =======================
       VALIDATION
    ======================= */
    if (empty($username) || empty($email) || empty($gender_id) || empty($faculty_id) || empty($status_id) || empty($age)) {
        $response['status']  = 'error';
        $response['message'] = 'Все поля обязательны';
        echo json_encode($response);
        exit;
    }

    /* =======================
       UPDATE
    ======================= */
    if (!empty($id)) {
        $stmt = $conn->prepare("
            UPDATE users
            SET username = ?, email = ?, gender_id = ?, faculty_id = ?, status_id = ?
            WHERE id = ?
        ");
        $stmt->bind_param("ssiiiii", $username, $email, $gender_id, $faculty_id, $status_id, $id);
        $stmt->execute();
        $stmt->close();

        $response['message'] = 'Пользователь обновлён';
        $response['users'] = loadUsers($conn);
        echo json_encode($response);
        exit;
    }

    /* =======================
       INSERT
    ======================= */
    $stmt = $conn->prepare("
        INSERT INTO users (username, email, gender_id, faculty_id, status_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssiiii", $username, $email, $gender_id, $faculty_id, $status_id);
    $stmt->execute();
    $stmt->close();

    $response['message'] = 'Пользователь добавлен';
    $response['users'] = loadUsers($conn);
    echo json_encode($response);
    exit;
}
