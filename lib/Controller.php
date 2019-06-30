<?php

namespace lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\PhpEngine;

/**
 * Class Controller
 * @package lib
 */
abstract class Controller extends Component
{
    /** @var PhpEngine */
    protected $view;
    /** @var EntityManager */
    protected $entityManager;
    /** @var Request */
    protected $request;

    /**
     * @throws \Exception
     */
    protected function init()
    {
        parent::init();

        $this->view = $this->di->getService('view');
        $this->request = $this->di->getService('request');
        $this->entityManager = $this->di->getService('em');
    }

    /**
     * @param string $path
     * @param int $status
     * @param array $headers
     * @return RedirectResponse
     */
    protected function redirect(string $path, int $status = 302, array $headers = []): RedirectResponse
    {
        return new RedirectResponse($path, $status, $headers);
    }

    /**
     * @param $name
     * @param array $params
     * @return Response
     */
    protected function render($name, array $params = []): Response
    {
        $content = $this->view->render($name, $params);

        return new Response($content);
    }
}
