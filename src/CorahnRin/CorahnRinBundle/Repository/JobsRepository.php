<?php

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Jobs;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class JobsRepository extends BaseRepository
{
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
