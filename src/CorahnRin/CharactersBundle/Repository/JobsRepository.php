<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * JobsRepository
 *
 */
class JobsRepository extends CorahnRinRepository {

    public function findAllPerBook($format = true) {
        $jobs = $this->findAll($format);
        $jobs_ordered = array();
        foreach ($jobs as $job) {
            $jobs_ordered[$job->getBook()->getId()][] = $job;
        }
        return $jobs_ordered;
    }
}