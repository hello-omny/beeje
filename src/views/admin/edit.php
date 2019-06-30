<?php

/**
 * @var \Symfony\Component\Templating\PhpEngine $view
 * @var \app\entity\Task $model
 */

$view->extend(__DIR__ . '/../layout/main.php');
$view['slots']->set('title', sprintf('Admin: Edit task #%d', $model->getId()));
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Task info</h5>
                <form action="" method="post">
                    <div class="form-group">
                        <textarea class="form-control" name="task[text]" placeholder="Enter text" required><?= $model->getText() ?></textarea>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="task[status]">
                            <option value="1">Активно</option>
                            <option value="0">Закрыто</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-4">
                <h5>User info</h5>
                <ul>
                    <li><?= $model->getUserName() ?></li>
                    <li><?= $model->getEmail() ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>