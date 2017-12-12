<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Jobs;
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

    /**
     * @param int $id
     *
     * @return Jobs|null
     */
    public function findWithDomains($id)
    {
        return $this->createQueryBuilder('job')
            ->leftJoin('job.domainPrimary', 'domainPrimary')
                ->addSelect('domainPrimary')
            ->leftJoin('job.domainsSecondary', 'domainsSecondary')
                ->addSelect('domainsSecondary')
            ->where('job.id = :id')
                ->setParameter('id', $id)
            ->getQuery()->getOneOrNullResult()
        ;
    }
}
