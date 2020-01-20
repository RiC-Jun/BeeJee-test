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
    <title>Список задач</title>
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
    <?php else : ?>
        <li class="nav-item login">
            <a class="nav-link btn-info" href="/login/">Авторизация</a>
        </li>
    <?php endif; ?>
</ul>

<h1>Список задач</h1>

<?php if($this->message) :?>
    <div class="alert alert-success" role="alert">
        <?= $this->message ?>
    </div>
<?php endif; ?>

<section>
<form action="/" method="get" class="sort-form">
    <label for="fields">Сортировка:
        <select id="fields" name="field" class="form-control">
            <?php foreach ($this->sorting['fields'] as $field): ?>
                <option value="<?= $field['value'] ?>" <?php if($field['active']){echo 'selected';} ?>>
                    <?= $field['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <label for="direction">Направление:
        <select id="direction" name="direction" class="form-control">
            <?php foreach ($this->sorting['direction'] as $field): ?>
                <option value="<?= $field['value'] ?>" <?php if($field['active']){echo 'selected';} ?>>
                    <?= $field['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <?php if($this->currentPage != 1) : ?>
        <input type="hidden" name="page" value="<?= $this->currentPage ?>">
    <?php endif; ?>
    <button type="submit" class="btn btn-info">Сортировать</button>
</form>

<?php foreach ($this->tasks as $task): ?>
    <article class="card">
        <p><?= $task->description ?></p>
        <div class="row justify-content-between">
            <p class="blockquote-footer">
                <span>Имя: <b><?= $task->username ?></b></span>
                <span>Email: <b><?= $task->email ?></b></span>
            </p>
            <?php if ($this->admin) : ?>
                <a href="/task/?id=<?= $task->id ?>" class="pull-right">
                    Проверить задачу
                </a>
            <?php endif; ?>
        </div>
        <?php if($task->checked || $task->edited) :?>
        <div class="row justify-content-start">
            <p class="blockquote-footer">
                <?php if($task->checked) :?>
                    <span class="text-success">Выполнено</span>
                <?php endif; ?>
                <?php if($task->edited) :?>
                    <span class="text-warning">Отредактировано админом</span>
                <?php endif; ?>
            </p>
        </div>
        <?php endif; ?>
    </article>
<?php endforeach; ?>

<?php if ($this->pagination): ?>
    <nav>
        <?= $this->pagination ?>
    </nav>
<?php endif; ?>
</section>

<section>
    <h1>Напишите свою задачу</h1>
    <form action="/taskAppender/" method="post" id="send-task-form" class="col-md-6 order-md-1">
        <div class="form-group">
            <label for="username">Имя</label>
            <input name="username" type="text" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group">
            <label for="description">Описание задачи</label>
            <textarea name="description" class="form-control" id="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-info btn-block">Отправить</button>
    </form>
</section>

</body>
</html>