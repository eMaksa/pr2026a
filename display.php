<div id="message"></div>

<table>
    <tr>
        <th onclick="sortTable('username')" style="cursor:pointer">Username ▲▼</th>
        <th onclick="sortTable('email')" style="cursor:pointer">Email ▲▼</th>
        <th onclick="sortTable('gender')" style="cursor:pointer">Gender ▲▼</th>
        <th onclick="sortTable('faculty')" style="cursor:pointer">Faculty ▲▼</th>
        <th>Edit</th>
    </tr>
    <tbody id="usersBody">
        <tr>
            <td colspan="5">Пользователей пока нет</td>
        </tr>
    </tbody>
</table>

<br>
<a href="export_csv.php">
    <button type="button">Скачать CSV</button>
</a>

<br>
<br>
<a href="random_student.php" target="_blank">
    <button type="button">🎲 Случайный студент дня</button>
</a>
