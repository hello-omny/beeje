<?php

namespace app\providers;

use app\entity\Task;

/**
 * Class TaskProvider
 * @package app\providers
 */
class TaskProvider
{
    /**
     * @param array $params
     * @param Task|null $task
     * @return Task
     */
    public function load(array $params, Task $task = null): Task
    {
        if ($task === null) {
            $task = new Task();
        }

        if (array_key_exists('text', $params)) {
            $task->setText($params['text']);
        }
        if (array_key_exists('status', $params)) {
            $task->setStatus($params['status']);
        }

        return $task;
    }
}
