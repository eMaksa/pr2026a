<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
 <meta charset="UTF-8">
 <title>Управление пользователями</title>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #eaeaea;
        }
    </style>
</head>
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