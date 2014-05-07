<?php
/**
 * Lieu de résidence géographique
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$geoEnvironments = $this->em->getRepository('CorahnRinCharactersBundle:GeoEnvironments')->findAll(true);

$datas = array(
    'geoEnvironments' => $geoEnvironments,
    'geoEnvironment_value' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null),
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $geoEnvironment_id = (int) $this->request->request->get('gen-div-choice');
    if (isset($geoEnvironments[$geoEnvironment_id])) {
        $this->characterSet($geoEnvironment_id);
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('Veuillez indiquer un peuple correct.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;