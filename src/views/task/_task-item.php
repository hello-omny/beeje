<?php

/**
 * @var \Symfony\Component\Templating\PhpEngine $view
 * @var \app\entity\Task $model
 */

?>
<ul>
    <?=$model->getText()?>
    <ul class="list-inline">
        <li class="list-inline-item"><span class="badge badge-primary"><?=$model->getStatus()?></span></li>
        <li class="list-inline-item"><?=$model->getUserName()?></li>
        <li class="list-inline-item"><?=$model->getEmail()?></li>
    </ul>
</ul>
