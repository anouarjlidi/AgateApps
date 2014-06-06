<?php
/**
 * Métier
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$jobs = $this->em->getRepository('CorahnRinCharactersBundle:Jobs')->findAllPerBook();

$datas = array(
    'job_value' => isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null,
    'jobs_list' => $jobs,
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $job_value = (int) $this->request->request->get('job_value');
	$job_exists = false;

    foreach ($jobs as $id => $jobs_list) {
        if (isset($jobs_list[$job_value])) { $job_exists = true; }
    }

    if ($job_exists) {
        $this->characterSet($job_value);
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('Veuillez entrer un métier correct.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;