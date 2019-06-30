<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();

$routes->add('task-index', new Route(
    '/task/{page}',
    ['_controller' => "\app\controllers\TaskController::index", 'page' => 1],
    ['page' => '\d*']
));

$routes->add('task-create', new Route(
    '/task/create',
    ['_controller' => "\app\controllers\TaskController::create"]
));

$routes->add('task-view', new Route(
    '/task/view/{id}',
    ['_controller' => "\app\controllers\TaskController::view"],
    ['page' => '\d']
));

$routes->add('admin-index', new Route(
    'admin/{page}',
    ['_controller' => '\app\controllers\AdminController::index', 'page' => 1],
    ['page' => '\d*']
));

$routes->add('admin-task-edit', new Route(
    '/admin/edit/{id}',
    ['_controller' => "\app\controllers\adminController::edit"],
    ['page' => '\d']
));

return $routes;
