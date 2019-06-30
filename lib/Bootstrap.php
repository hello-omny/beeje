<?php

namespace lib;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * Class Bootstrap
 * @package lib
 */
class Bootstrap
{
    private const CONFIG_PATH = __DIR__ . '/../config/';
    private const EXCLUDE_CONFIG_PARTS = ['..', '.'];

    /** @var DependencyInjector */
    private $di;

    /**
     * Bootstrap constructor.
     * @param DependencyInjector $di
     */
    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
    }

    /**
     * @return DependencyInjector
     */
    public function getDi(): DependencyInjector
    {
        return $this->di;
    }

    /**
     * Loading config
     */
    public function config(): void
    {
        $this->getDi()->register('config',
            function () {
                $config = new Config();
                $configFiles = array_diff(scandir(self::CONFIG_PATH), self::EXCLUDE_CONFIG_PARTS);

                foreach ($configFiles as $file) {
                    $name = explode('.', $file)[0];
                    $params = require sprintf("%s%s", self::CONFIG_PATH, $file);
                    $config->set($name, $params);
                }

                return $config;
            }
        );
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        /** @var Config $config */
        $config = $this->getDi()->getService('config');

        $this->getDi()->register('session', function () {
            return new Session();
        });

        $this->getDi()->register('request', function () {
            return Request::createFromGlobals();
        });

        $this->getDi()->register('context', function () {
            $request = $this->getDi()->getService('request');
            return (new RequestContext())->fromRequest($request);
        });

        $this->getDi()->register('matcher', function () use ($config) {
            $routes = $config->get('routes');
            $context = $this->getDi()->getService('context');
            return (new UrlMatcher(
                $routes,
                $context
            ));
        });

        $this->getDi()->register('requestStack', function () {
            return new RequestStack();
        });

        $this->getDi()->register('dispatcher', function () {
            $dispatcher = new EventDispatcher();
            $matcher = $this->getDi()->getService('matcher');
            $requestStack = $this->getDi()->getService('requestStack');
            $dispatcher->addSubscriber(new RouterListener(
                $matcher, $requestStack
            ));

            return $dispatcher;
        });

        $this->getDi()->register('resolver', function () {
            return new ControllerResolver();
        });

        $this->getDi()->register('argumentResolver', function () {
            return new ArgumentResolver();
        });

        $this->getDi()->register('view', function () use ($config) {
            $viewConfig = $config->get('view');
            $path = 'src/views';
            if (array_key_exists('viewPath', $viewConfig)) {
                $path = $viewConfig['viewPath'];
            }
            $viewPath = sprintf('%s/../%s/%s', __DIR__, $path, '%name%.php');
            $filesystemLoader = new FilesystemLoader([$viewPath]);

            return new PhpEngine(
                new TemplateNameParser(),
                $filesystemLoader,
                [
                    new SlotsHelper(),
                    new RouterHelper(new UrlGenerator(
                        $config->get('routes'),
                        $this->getDi()->getService('context')
                    )),
                ]
            );
        });

        $this->getDi()->register('db', function () use ($config) {
            return DriverManager::getConnection(
                $config->get('db'),
                new Configuration()
            );
        });

        $this->getDi()->register('em', function () use ($config) {
            $emConfig = $config->get('em');

            $isDevMode = false;
            if (array_key_exists('devMode', $emConfig)) {
                $isDevMode = $emConfig['devMode'];
            }
            $path = __DIR__ . '/../src/entity';
            if (array_key_exists('path', $emConfig)) {
                $path = $emConfig['path'];
            }

            $config = Setup::createAnnotationMetadataConfiguration(
                [$path],
                $isDevMode
            );

            return EntityManager::create(
                $this->getDi()->getService('db'),
                $config
            );
        });
    }
}
