<?php

namespace lib;

use lib\traits\Singleton;

/**
 * TODO: plz, use symfony components
 * Class DependencyInjector
 * @package lib
 */
class DependencyInjector
{
    use Singleton;

    /** @var array */
    private $services = [];

    /**
     * @param string $serviceName
     * @return mixed
     * @throws \Exception
     */
    public function __get(string $serviceName)
    {
        return $this->getService($serviceName);
    }

    /**
     * @param string $serviceName
     * @param callable $callable
     */
    public function __set(string $serviceName, callable $callable): void
    {
        $this->register($serviceName, $callable);
    }

    /**
     * @param string $serviceName
     * @param array $config
     * @return mixed
     * @throws \Exception
     */
    public function getService(string $serviceName, array $config = [])
    {
        if (!array_key_exists($serviceName, $this->services)) {
            throw new \Exception(sprintf(
                "The Service: %s does not exist.",
                $serviceName
            ));
        }

        $service = $this->services[$serviceName];
        if ($service instanceof \Closure) {
            return $service();
        }

        return $service($config);
    }

    /**
     * @param string $serviceName
     * @param callable $callable
     */
    public function register(string $serviceName, callable $callable): void
    {
        $this->services[$serviceName] = $callable;
    }
}
