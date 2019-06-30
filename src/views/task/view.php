<?php

/**
 * @var \Symfony\Component\Templating\PhpEngine $view
 * @var \app\entity\Task $model
 */

$view->extend(__DIR__ . '/../layout/main.php');
$view['slots']->set('title', sprintf('Task #%d', $model->getId()));
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul>
                    <li><?=$model->getText()?></li>
                    <li><?=$model->getUserName()?></li>
                    <li><?=$model->getEmail()?></li>
                    <li><?=$model->getStatus()?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
