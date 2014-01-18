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
    if (isset($jobs[$job_value])) {
        $character[$this->stepFullName()] = $job_value;
        $session->set('character', $character);
        return $controller->_nextStep($this->step);
    } else {
        $msg = $controller->get('translator')->trans('Veuillez entrer un métier correct.', array(), 'error.steps');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;