<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if ($this->css && $this->cssPath) : ?>
        <?php foreach ($this->css as $cssFile) : ?>
            <link rel="stylesheet" href="<?= $this->cssPath . $cssFile ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <title>Аутентификация</title>
</head>
<body>
<ul class="nav justify-content-start">
    <li class="nav-item">
        <a class="nav-link active" href="/">На главную</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/#send-task-form">Добавить задачу</a>
    </li>
    <?php if ($this->admin) : ?>
        <li class="nav-item login">
            <a class="nav-link btn-info" href="/logout/">Выйти</a>
        </li>
    <?php endif; ?>
</ul>

<h1>Авторизация</h1>

<?php if($this->message) :?>
    <div class="alert alert-danger" role="alert">
        <?= $this->message ?>
    </div>
<?php endif; ?>

<?php if (!$this->admin) : ?>
<form action="/authentification/" method="post" class="col-md-6 order-md-1">
    <div class="form-group">
        <label for="login">Логин</label>
        <input name="login" type="text" id="login" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input name="password" type="password" class="form-control" id="password" required>
    </div>
    <button type="submit" class="btn btn-info btn-block">Отправить</button>
</form>
<?php else : ?>
    <p>Вы уже авторизованы!</p>
<?php endif; ?>

</body>
</html>