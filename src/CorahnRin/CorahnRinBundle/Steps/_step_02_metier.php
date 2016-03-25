<?php
/**
 * Métier.
 * 
 * @var $this CorahnRin\CorahnRinBundle\Steps\StepLoader
 */
$jobs = $this->em->getRepository('CorahnRinBundle:Jobs')->findAllPerBook();

$datas = array(
    'job_value' => isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null,
    'jobs_list' => $jobs,
);

if ($this->request->isMethod('POST')) {
    $job_value = (int) $this->request->request->get('job_value');
    $job_exists = false;

    foreach ($jobs as $id => $jobs_list) {
        if (isset($jobs_list[$job_value])) {
            $job_exists = true;
        }
    }

    if ($job_exists) {
        $this->characterSet($job_value);

        return $this->nextStep();
    } else {
        $this->flashMessage('Veuillez entrer un métier correct.');
    }
}

return $datas;
