<?php

namespace lib;

/**
 * Class Component
 * @package lib
 */
abstract class Component
{
    /** @var DependencyInjector */
    protected $di;

    /**
     * Controller constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * @throws \Exception
     */
    protected function init()
    {
        $this->di = DependencyInjector::getInstance();
    }
}
