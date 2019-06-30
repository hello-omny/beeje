<?php

namespace app\controllers;

use app\providers\TaskProvider;
use app\providers\UserProvider;
use app\repositories\UserRepository;
use lib\Controller;
use app\entity\Task;
use app\entity\User;
use app\repositories\TaskRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TaskController
 * @package app\controllers
 */
class TaskController extends Controller
{
    private const PAGE_SIZE = 3;

    /**
     * @param int $page
     * @return Response
     */
    public function index(int $page)
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        $paginator = $taskRepository->getPaginated($page, self::PAGE_SIZE);
        $totalCount = $paginator->getIterator()->count();
        $maxPages = ceil($totalCount / self::PAGE_SIZE);
        $currentPage = $page;

        return $this->render('task/index', compact(
            'totalCount',
            'paginator',
            'maxPages',
            'currentPage'
        ));
    }

    /**
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function create()
    {
        if ($this->request->isMethod('POST')) {
            $userParams = $this->request->request->get('user');
            if (array_key_exists('email', $userParams)) {
                /** @var UserRepository $userRepository */
                $userRepository = $this->entityManager->getRepository(User::class);
                $user = $userRepository->findByEmail($userParams['email']);

                if ($user === null) {
                    $user = (new UserProvider())->load($userParams);
                    $this->entityManager->persist($user);
                }
            } else {
                throw new \Exception('User email not valid.');
            }
            $taskParams = $this->request->request->get('task');
            if (array_key_exists('text', $taskParams)) {
                $task = (new TaskProvider())->load($taskParams);
                $task->setUser($user);
                $this->entityManager->persist($task);
            } else {
                throw new \Exception('Task params not valid.');
            }
            $this->entityManager->flush();

            return $this->redirect('/task');
        }

        return $this->render('task/create');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function view(int $id)
    {
        $model = $this->entityManager
            ->find(Task::class, $id);

        return $this->render('task/view', compact('model'));
    }
}
