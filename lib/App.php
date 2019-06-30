<?php

namespace lib;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class App
 * @package lib
 */
class App
{
    /** @var Bootstrap */
    private $bootstrap;
    /** @var DependencyInjector */
    private $di;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->di = DependencyInjector::getInstance();
        $this->bootstrap = new Bootstrap($this->di);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function run()
    {
        $this->bootstrap->config();
        $this->bootstrap->run();
        $response = $this->handle($this->di->getService('request'));

        return $response->send();
    }

    /**
     * @param Request $request
     * @return mixed|Response
     */
    private function handle(Request $request)
    {
        try {
            $params = $this->di
                ->getService('matcher')
                ->match($request->getPathInfo());
            $request->attributes->add($params);
            $controller = $this->di
                ->getService('resolver')
                ->getController($request);
            $arguments = $this->di
                ->getService('argumentResolver')
                ->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            return new Response('Not Found', 404);
        } catch (\Exception $exception) {
            $message = sprintf(
                "An error occurred: %s <br> File: %s <br> Line: %d",
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            );

            return new Response($message, 500);
        }
    }
}
