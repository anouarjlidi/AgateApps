<?php
/**
 * Lieu de naissance
 */

$regions = $controller->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Zones')->findAll(true);

$datas = array(
    'regions_list' => $regions,
    'region_value' => (isset($character[$this->stepFullName()]) ? (int) $character[$this->stepFullName()] : null),
);

if ($request->isMethod('POST')) {
    $region_value = (int) $request->request->get('region_value');
    if (isset($regions[$region_value])) {
        $character[$this->stepFullName()] = $region_value;
        $session->set('character', $character);
        return $controller->_nextStep($this->step);
    } else {
        $msg = $controller->get('translator')->trans('Veuillez entrer un métier correct.', array(), 'error.steps');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;