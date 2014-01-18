<?php
/**
 * Métier
 */

//$books = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Books')->findAll(true);
//$jobs = array();foreach ($t as $v) { $jobs[$v->getId()] = $v; }unset($t);

$jobs_list = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Jobs')->findAllPerBook();

$datas['jobs_list'] = $jobs_list;
$datas['job_value'] = '';

$character_job = $session->get('character.job');
$character_jobCustom = $session->get('character.jobCustom');

if ($character_job) {
    $datas['job_value'] = $character_job;
} elseif ($character_jobCustom) {
    $datas['job_value'] = $character_jobCustom;
}

if ($request->isMethod('POST')) {
    $job_value = $request->request->get('job_value');
    if (isset($jobs[$job_value])) {
        $session->set('character.job', $job_value);
        return $controller->_nextStep($session, $request);
    } elseif ($job_value && !is_numeric($job_value)) {
        $session->set('character.jobCustom', $job_value);
        return $controller->_nextStep($session, $request);
    } else {
        $translator = $controller->get('translator');
        $translator->translationDomain('error.steps');
        $msg = $translator->translate('Une erreur est survenue : mauvais contenu envoyé au personnage');
        $translator->translationDomain();
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;