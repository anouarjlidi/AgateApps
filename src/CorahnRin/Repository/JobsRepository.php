<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Repository;

use CorahnRin\Entity\Jobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JobsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Jobs::class);
    }

    /**
     * Renvoie la liste des métiers triés par livre associé.
     *
     * @return Jobs[][]
     */
    public function findAllPerBook()
    {
        /** @var Jobs[] $jobs */
        $jobs = $this->findAll();

        $books = [];

        foreach ($jobs as $job) {
            $books[$job->getBook()->getId()][$job->getId()] = $job;
        }

        return $books;
    }
}
