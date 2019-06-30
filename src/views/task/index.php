<?php

/**
 * @var \Symfony\Component\Templating\PhpEngine $view
 * @var int $totalCount
 * @var int $maxPages
 * @var int $currentPage
 * @var \Doctrine\ORM\Tools\Pagination\Paginator $paginator
 */

$view->extend(__DIR__ . '/../layout/main.php');
$view['slots']->set('title', 'List of tasks');

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <p>
                    <?php if ($maxPages > 1): ?>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $maxPages + 1; $i++): ?>
                        <li class="page-item <?= $currentPage === $i ? 'disabled' : '' ?>">
                            <a class="page-link" href="/task/<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
                <?php endif; ?>
                </p>
                <hr>
                <?php foreach ($paginator as $task) : ?>
                    <?= $view->render('task/_task-item', ['model' => $task]) ?>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
