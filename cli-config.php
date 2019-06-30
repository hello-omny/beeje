<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require(__DIR__ . '/vendor/autoload.php');

$isDevMode = true;
$paths = array(__DIR__ . '/src/entity');
$config = Setup::createAnnotationMetadataConfiguration(
    $paths,
    $isDevMode,
    null,
    null,
    false
);

$dbParams = include(__DIR__ . '/config/db.php');

$entityManager = EntityManager::create(
    $dbParams,
    $config
);

return ConsoleRunner::createHelperSet($entityManager);
