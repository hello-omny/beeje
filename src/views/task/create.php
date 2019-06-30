<?php

/**
 * @var \Symfony\Component\Templating\PhpEngine $view
 */

$view->extend(__DIR__ . '/../layout/main.php');
$view['slots']->set('title', 'Create task');
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <form action="/task/create" method="post">
                    <div class="form-group">
                        <label for="task[text]">Text</label>
                        <textarea class="form-control" name="task[text]" placeholder="Enter text" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="user[name]">User name</label>
                        <input type="text" class="form-control" name="user[name]" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <label for="user[email]">Email</label>
                        <input type="email" class="form-control" name="user[email]" placeholder="Enter email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
