<?php
namespace CorahnRin\CorahnRinBundle\Repository;

use Pierstoval\Bundle\ToolsBundle\Repository\BaseRepository;

/**
 * JobsRepository
 *
 */
class JobsRepository extends BaseRepository {

    /**
     * Renvoie la liste des métiers triés par livre associé.
     *
     * @param bool $format
     * @return array
     */
    public function findAllPerBook($format = true) {
        $jobs = $this->findAll($format);
        $jobs_ordered = array();
        foreach ($jobs as $job) {
            $jobs_ordered[$job->getBook()->getId()][] = $job;
        }
        return $jobs_ordered;
    }
}