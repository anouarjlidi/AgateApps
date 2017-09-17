<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Repository;

use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use UserBundle\Entity\User;
use UserBundle\Util\Canonicalizer;

class UserRepository extends BaseEntityRepository
{
    /**
     * @var Canonicalizer
     */
    protected $canonicalizer;

    public function setCanonicalizer(Canonicalizer $canonicalizer)
    {
        $this->canonicalizer = $canonicalizer;
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ?User
    {
        return $this->createQueryBuilder('user')
            ->where('user.usernameCanonical = :usernameOrEmail')
            ->orWhere('user.emailCanonical = :usernameOrEmail')
            ->setParameter('usernameOrEmail', $this->canonicalizer->canonicalize($usernameOrEmail))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByEmail($email): ?User
    {
        $email = $this->canonicalizer->canonicalize($email);

        return $this->findOneBy(['emailCanonical' => $email]);
    }

    public function findOneByConfirmationToken($token): ?User
    {
        return $this->findOneBy(['confirmationToken' => $token]);
    }
}
