<?php
/**
 * Métier
 */

//$books = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Books')->findAll(true);
//$jobs = array();foreach ($t as $v) { $jobs[$v->getId()] = $v; }unset($t);

$jobs = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Jobs')->findAll(true);
$jobs_ordered = array();
foreach ($jobs as $job) {
//    $jobs_ordered[$job->getBook()->getId()]['book_name'] = $job->getBook()->getName();
    $jobs_ordered[$job->getBook()->getId()][] = $job;
}

$datas['jobs_list'] = $jobs_ordered;
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
        $translator = $controller->get('corahn_rin_translate');
        $translator->routeTemplate('corahnrin_characters_generator_step');
        $msg = $translator->translate('Une erreur est survenue : mauvais contenu envoyé au personnage');
        $translator->routeTemplate();
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;