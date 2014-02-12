<?php
/**
 * Métier
 */

$jobs = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Jobs')->findAllPerBook();

$datas = array(
    'job_value' => isset($character[$this->stepFullName()]) ? (int) $character[$this->stepFullName()] : null,
    'jobs_list' => $jobs,
);

if ($request->isMethod('POST')) {
    $job_value = (int) $request->request->get('job_value');
	$job_exists = false;

    for ($i = 0, $c = count($jobs_list) ; $i < $c ; $i++){
        if (isset($jobs_list[$i][$job_value])) { $job_exists = true; $i = $c; }
    }

    if ($job_exists) {
        $character[$this->stepFullName()] = $job_value;
        $session->set('character', $character);
        return $controller->_nextStep($this->step);
    } else {
        $msg = $controller->get('translator')->trans('Veuillez entrer un métier correct.', array(), 'error.steps');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;