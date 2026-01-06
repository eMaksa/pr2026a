<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
 <meta charset="UTF-8">
 <title>Управление пользователями</title>
 <link rel="stylesheet" href="style.css"> </head>
<body>
 <h1>Система учета практикантов</h1>
 <section>
 <h2>Добавить нового пользователя</h2>
 <?php include 'form.php'; ?>
 </section>
 <hr>
 <section>
 <h2>Список пользователей</h2>
 <?php include 'display.php'; ?>
 </section>
</body>
</html>