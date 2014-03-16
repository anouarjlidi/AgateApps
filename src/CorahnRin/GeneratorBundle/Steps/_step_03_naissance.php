<?php
/**
 * Lieu de naissance
 */

$regions = $this->em->getRepository('CorahnRinMapsBundle:Zones')->findAll(true);

$datas = array(
    'regions_list' => $regions,
    'region_value' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null),
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $region_value = (int) $this->request->request->get('region_value');
    if (isset($regions[$region_value])) {
        $this->character[$this->stepFullName()] = $region_value;
        $this->session->set('character', $this->character);
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('Veuillez entrer un métier correct.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;