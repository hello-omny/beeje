<?php

namespace lib;

/**
 * Class Config
 * @package lib
 */
class Config
{
    /** @var array */
    private $items;

    /**
     * Config constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        throw new \Exception("Key {$key} dose not exist.");
    }
}
