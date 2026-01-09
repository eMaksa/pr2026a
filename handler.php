<?php
require_once 'db.php';
header('Content-Type: application/json'); // Говорим браузеру, что это JSON
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    if (empty($username) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Все поля обязательны!']);
        exit;
    }
    $sql = "INSERT INTO users (username, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Пользователь добавлен!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка базы: ' . $conn->error]);
    }
    $stmt->close();
}
