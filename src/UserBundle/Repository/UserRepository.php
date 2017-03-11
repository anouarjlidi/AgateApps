<?php

namespace UserBundle\Repository;

use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use UserBundle\Entity\User;

class UserRepository extends BaseEntityRepository
{
    /**
     * @param string $usernameOrEmail
     * @return User|null
     */
    public function findByUsernameOrEmail($usernameOrEmail)
    {
        return $this->createQueryBuilder('user')
            ->where('user.usernameCanonical = :usernameOrEmail')
            ->orWhere('user.emailCanonical = :usernameOrEmail')
            ->setParameter('usernameOrEmail', mb_convert_case(trim($usernameOrEmail), MB_CASE_LOWER))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
