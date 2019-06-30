<?php

namespace app\repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package app\repositories
 */
class UserRepository extends EntityRepository
{
    /**
     * @param string $email
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmail(string $email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter(':email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}