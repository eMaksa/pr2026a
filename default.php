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

        th,
        td {
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
    <script>
        let currentSort = {
            field: null,
            asc: true
        };

        function sortTable(field) {
            currentSort.asc = (currentSort.field === field) ? !currentSort.asc : true;
            currentSort.field = field;

            fetch('handler.php')
                .then(r => r.json())
                .then(data => {
                    let users = data.users;

                    users.sort((a, b) => {
                        if (a[field] < b[field]) return currentSort.asc ? -1 : 1;
                        if (a[field] > b[field]) return currentSort.asc ? 1 : -1;
                        return 0;
                    });

                    renderTable(users);
                });
        }

        const messageDiv = document.getElementById('message');
        const usersBody = document.getElementById('usersBody');
        const form = document.querySelector('form');

        function renderTable(users) {
            usersBody.innerHTML = '';
            if (!users.length) {
                usersBody.innerHTML = '<tr><td colspan="5">Пользователей пока нет</td></tr>';
                return;
            }
            users.forEach(u => {
                usersBody.innerHTML += `
    <tr>
        <td>${u.username}</td>
        <td>${u.email}</td>
        <td>${u.gender}</td>
        <td>${u.faculty}</td>
        <td>
            <button onclick="editUser(
                ${u.id},
                '${u.username}',
                '${u.email}',
                ${u.gender_id},
                ${u.faculty_id}
            )">
                Редактировать
            </button>

            <button onclick="deleteUser(${u.id})">
                Удалить
            </button>
        </td>
    </tr>`;
            });
        }

        function editUser(id, username, email, gender_id, faculty_id) {
    document.getElementById('user_id').value = id;
    document.getElementById('username').value = username;
    document.querySelector('input[name="email"]').value = email;

    document.getElementById('gender').value = gender_id;
    document.getElementById('faculty').value = faculty_id;
}

        function deleteUser(id) {
            if (!confirm('Удалить пользователя?')) return;

            const formData = new FormData();
            formData.append('delete_id', id);

            fetch('handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    messageDiv.textContent = data.message;
                    messageDiv.style.color = data.status === 'success' ? 'green' : 'red';
                    renderTable(data.users);
                });
        }

        fetch('handler.php')
            .then(r => r.json())
            .then(data => renderTable(data.users))
            .catch(() => {
                messageDiv.textContent = 'Ошибка при загрузке пользователей';
                messageDiv.style.color = 'red';
            });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('handler.php', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(r => r.json())
                .then(data => {
                    messageDiv.textContent = data.message;
                    messageDiv.style.color = data.status === 'success' ? 'green' : 'red';
                    if (data.status === 'success') {
                        renderTable(data.users);
                        form.reset();
                    }
                })
                .catch(err => {
                    console.error(err); // для консоли разработчика

                    messageDiv.textContent =
                        err.message ?
                        `Ошибка: ${err.message}` :
                        'Неизвестная ошибка при отправке запроса';

                    messageDiv.style.color = 'red';
                });
        });
    </script>
</body>

</html>