<?php

/**
 * @var \Symfony\Component\Templating\PhpEngine $view
 */

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title><?php $view['slots']->output('title', 'Default title') ?></title>
</head>
<body>

<section>
    <div class="container">
        <div class="row">
            <div class="col"><h3>Tasks</h3></div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="float-left list-inline">
                    <li class="list-inline-item">
                        <a href="<?=$view['router']->path('task-index')?>">List</a></li>
                    <li class="list-inline-item">
                        <a href="<?=$view['router']->path('task-create')?>">Create one</a></li>
                </ul>
                <div class="float-right"><a href="<?=$view['router']->path('admin-index')?>">Admin area</a></div>
            </div>
        </div>
    </div>
</section>
<hr>
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><?php $view['slots']->output('title', 'Default title') ?></h1>
            </div>
        </div>
    </div>
</section>

<?php $view['slots']->output('_content') ?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>