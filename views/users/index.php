<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link <?= ($action == 'load_from_file' ? 'active' : '') ?>" href="/users/file/show">Файл</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($action == 'load_from_db' ? 'active' : '') ?>" href="/users/db/show">База данных</a>
        </li>
    </ul>
</nav>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">Фамилия</th>
        <th scope="col">Телефон</th>
        <th scope="col">Email</th>
        <th scope="col">Адрес</th>
        <th scope="col">Зарегистрирован</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <th scope="row"><?= $userCounter++ ?></th>
            <td><?= $user['first_name'] ?></td>
            <td><?= $user['last_name'] ?></td>
            <td><?= $user['phone'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
                <?php foreach ($user['location'] as $key => $value): ?>
                    <?php if (!is_array($value)) {
                        echo ucfirst($key) . ": $value";
                    } ?>
                <?php endforeach ?>
            </td>
            <td><?= $date->format('d ' . $month . ' Y H:i:s') ?></td>
            <td>
                <?php if ($action == 'load_from_db') { ?>
                    <a href="/users/db/delete/<?= $user['uuid'] ?>" class="btn btn-danger">Удалить</a>
                <?php } else { ?>
                    <a href="/users/file/delete/<?= $user['uuid'] ?>" class="btn btn-danger">Удалить</a>
                <?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="container-fluid">
    <?php if ($action == 'load_from_db') { ?>
        <a class="btn btn-success float-right" href="/users/db/generate" role="button">Сгенерировать в базе</a>
    <?php } else { ?>
        <a class="btn btn-success float-right" href="/users/file/generate" role="button">Сгенерировать в файле</a>
    <?php } ?>
</div>


</body>
</html>

