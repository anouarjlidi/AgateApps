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
            $books[$job->getBook()->getId()][] = $job;
        }

        return $books;
    }

}
