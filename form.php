<?php
require_once 'db.php';

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

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация пользователя</title>
</head>
<body>

<h2>Форма пользователя</h2>

<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <button type="submit">Сохранить</button>
</form>

</body>
</html>