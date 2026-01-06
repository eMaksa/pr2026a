<?php
// db.php
$host = 'localhost';
$user = 'root';
$pass = ''; // В XAMPP по умолчанию пароль пустой
$dbname = 'intern_project';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
 die("Ошибка подключения: " . $conn->connect_error);
}
?>
