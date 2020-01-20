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
        <title>Задача</title>
    </head>
    <body>

        <ul class="nav justify-content-start">
            <li class="nav-item">
                <a class="nav-link active" href="/">На главную</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/#send-task-form">Добавить задачу</a>
            </li>
            <li class="nav-item login">
                <a class="nav-link btn-info" href="/logout/">Выйти</a>
            </li>
        </ul>

        <h1>Список задач</h1>

        <?php if($this->message) :?>
            <div class="alert alert-success" role="alert">
                <?= $this->message ?>
            </div>
        <?php endif; ?>

        <p>
            <span>Имя: <b><?= $this->task->username ?></b></span>
            <span>Email: <b><?= $this->task->email ?></b></span>
        </p>
        <form action="/taskUpdater/" method="post" class="col-md-6 order-md-1">
            <div class="form-group">
                <label for="description">Описание задачи</label>
                <textarea name="description" class="form-control" id="description" rows="4" required><?= $this->task->description ?></textarea>
            </div>
            <div class="form-group">
                <input type="checkbox" id="checked" name="checked" <?php if($this->task->checked) :?>checked<?php endif; ?>>
                <label for="checked">Выполнено</label>
            </div>
            <input type="hidden" name="id" value="<?= $this->task->id ?>">
            <button type="submit" class="btn btn-info btn-block">Отправить</button>
        </form>
    </body>
</html>