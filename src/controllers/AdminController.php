<?php

namespace app\controllers;

use app\entity\Task;
use app\providers\TaskProvider;
use app\repositories\TaskRepository;
use lib\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AdminController
 * @package app\controllers
 */
class AdminController extends Controller
{
    private const PAGE_SIZE = 10;

    /**
     * @param int $page
     * @return Response
     */
    public function index(int $page): Response
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        $paginator = $taskRepository->getPaginated($page, self::PAGE_SIZE);
        $totalCount = $paginator->getIterator()->count();
        $maxPages = ceil($totalCount / self::PAGE_SIZE);
        $currentPage = $page;

        return $this->render('admin/index', compact(
            'totalCount',
            'paginator',
            'maxPages',
            'currentPage'
        ));
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function edit(int $id): Response
    {
        /** @var Task $model */
        $model = $this->entityManager->find(Task::class, $id);
        if ($model === null) {
            throw new NotFoundHttpException('Task not found.');
        }

        if ($this->request->isMethod('POST')) {
            $taskParams = $this->request->request->get('task');
            $model = (new TaskProvider())->load($taskParams, $model);
            $this->entityManager->persist($model);
            $this->entityManager->flush();

            return $this->redirect('/admin');
        }

        return $this->render('admin/edit', compact('model'));
    }
}
