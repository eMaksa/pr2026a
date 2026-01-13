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

    if (empty($username) || empty($email)) {
        $response['status'] = 'error';
        $response['message'] = 'Все поля обязательны!';
        echo json_encode($response);
        exit;
    }

    if (!empty($id)) {
        $stmt = $conn->prepare(
            "UPDATE users SET username = ?, email = ? WHERE id = ?"
        );
        $stmt->bind_param("ssi", $username, $email, $id);

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

    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);

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
