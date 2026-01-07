<?php

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);

    // Простая валидация
    if (empty($username) || empty($email)) {
        $message = "Все поля обязательны!";
    } else {
        $sql = "INSERT INTO users (username, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);

        if ($stmt->execute()) {
            $message = "Данные успешно сохранены!";
        } else {
            $message = "Ошибка при сохранении данных.";
        }

        $stmt->close();
    }
}
?>

<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <button type="submit" name="submit">Сохранить</button>
</form>