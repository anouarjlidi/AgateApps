<?php
/**
 * Métier
 */

$t = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Jobs')->findAll();
$jobs = array();
foreach ($t as $v) { $jobs[$v->getId()] = $v; }
unset($t);
$datas['jobs'] = $jobs;
$datas['jobs_value'] = '';

$character = $session->get('generator_character');

if ($character->getJob()) {
    $datas['job_value'] = $character->getJob()->getId();
} elseif ($character->getJobCustom()) {
    $datas['job_value'] = $character->getJobCustom();
}

if ($request->isMethod('POST')) {
    $job_value = $request->request->get('job_value');
    if (isset($peoples[$job_value])) {
        $character->setJob($jobs[$job_value]);
        $session->set('generator_character', $character);
        return $controller->_nextStep($session, $request);
    } elseif ($job_value && !is_numeric($job_value)) {
        $character->setJobCustom($job_value);
        $session->set('generator_character', $character);
        return $controller->_nextStep($session, $request);
    } else {
        $msg = $controller->get('corahn_rin_translate')->translate('Une erreur est survenue : mauvais contenu envoyé au personnage');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;