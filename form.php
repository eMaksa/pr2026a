<?php
$genders = $conn->query("SELECT id, name FROM genders");
$faculties = $conn->query("SELECT id, name FROM faculties");
?>

<form method="POST">
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

    <button type="submit">Сохранить</button>

</form>