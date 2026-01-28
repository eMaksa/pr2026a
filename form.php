<?php
$genders   = $conn->query("SELECT id, name FROM genders");
$faculties = $conn->query("SELECT id, name FROM faculties");
$statuses  = $conn->query("SELECT id, name FROM intern_status");
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
<select name="status_id" id="status">
    <option value="">-- выберите --</option>
    <?php while ($s = $statuses->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>">
            <?= htmlspecialchars($s['name']) ?>
        </option>
    <?php endwhile; ?>
</select><br><br>



    <button type="submit">Сохранить</button>
    <button type="button" id="searchBtn">Поиск</button>

</form>