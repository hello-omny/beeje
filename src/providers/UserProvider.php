<?php

namespace app\providers;

use app\entity\User;

/**
 * Class UserProvider
 * @package app\providers
 */
class UserProvider
{
    /**
     * @param array $params
     * @return User
     */
    public function load(array $params = []): User
    {
        $user = new User();
        if (array_key_exists('name', $params)) {
            $user->setName($params['name']);
        }
        if (array_key_exists('email', $params)) {
            $user->setEmail($params['email']);
        }

        return $user;
    }
}
