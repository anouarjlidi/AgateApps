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

        foreach ($jobs as $job) {
            yield $job->getBook()->getId() => $job;
        }
    }

}
