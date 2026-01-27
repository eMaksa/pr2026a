<?php
$genders = $conn->query("SELECT id, name FROM genders");
$faculties = $conn->query("SELECT id, name FROM faculties");
?>

<form method="POST" id="userForm">
    <input type="hidden" name="id" id="user_id">

    <label>Username:</label><br>
    <input type="text" id="username" name="username"><br><br>

    <label>Email:</label><br>
    <input type="email" id="email" name="email"><br><br>

    <label>Пол:</label><br>
    <select name="gender_id" id="gender">
        <option value="">-- выберите --</option>
        <?php while ($g = $genders->fetch_assoc()): ?>
            <option value="<?= $g['id'] ?>"><?= $g['name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Факультет:</label><br>
    <select name="faculty_id" id="faculty">
        <option value="">-- выберите --</option>
        <?php while ($f = $faculties->fetch_assoc()): ?>
            <option value="<?= $f['id'] ?>"><?= $f['name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Статус практики:</label><br>
    <select name="status_id">
        <option value="">-- выберите --</option>
        <option value="1">Ищет</option>
        <option value="2">Работает</option>
        <option value="3">Закончил</option>
    </select><br><br>


    <button type="submit">Сохранить</button>
    <button type="button" id="searchBtn">Поиск</button>

</form>