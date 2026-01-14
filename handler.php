<?php
require_once 'db.php';
header('Content-Type: application/json');

$response = ['status' => 'success', 'message' => '', 'users' => []];

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $result = $conn->query("SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
        $response['users'][] = $row;
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $id = $_POST['id'] ?? '';
    $gender_id  = $_POST['gender_id'] ?? '';

    $delete_id = $_POST['delete_id'] ?? '';

    if (!empty($delete_id)) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $response['message'] = 'Пользователь удалён!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Ошибка удаления';
        }

        $stmt->close();

        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()) {
            $response['users'][] = $row;
        }

        echo json_encode($response);
        exit;
    }

    if (empty($username) || empty($email) || empty($gender_id)) {
        $response['status'] = 'error';
        $response['message'] = 'Все поля обязательны!';
        echo json_encode($response);
        exit;
    }

    if (!empty($id)) {
        $stmt = $conn->prepare(
            "UPDATE users SET username = ?, email = ?, gender_id = ? WHERE id = ?"
        );
        $stmt->bind_param("ssi", $username, $email, $gender_id, $id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Пользователь обновлён!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Ошибка обновления: ' . $stmt->error;
        }

        $stmt->close();

        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()) {
            $response['users'][] = $row;
        }

        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, gender_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email, $gender_id);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Пользователь добавлен!';

        $stmt->close();

        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()) {
            $response['users'][] = $row;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Ошибка базы: ' . $stmt->error;
    }

    echo json_encode($response);
}
