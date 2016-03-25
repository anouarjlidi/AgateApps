<?php
/**
 * Lieu de naissance.
 * 
 * @var $this CorahnRin\CorahnRinBundle\Steps\StepLoader
 */
$regions = $this->em->getRepository('EsterenMapsBundle:Zones')->findAll(true);

$map_id = $this->controller->get('service_container')->getParameter('step_3_map_id');
$map = $this->em->getRepository('EsterenMapsBundle:Maps')->find($map_id);

$tile_size = $this->controller->get('service_container')->getParameter('esterenmaps.tile_size');

$datas = array(
    'map' => $map,
    'tile_size' => $tile_size,
    'regions_list' => $regions,
    'region_value' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null),
);

if ($this->request->isMethod('POST')) {
    $region_value = (int) $this->request->request->get('region_value');
    if (isset($regions[$region_value])) {
        $this->characterSet($region_value);

        return $this->nextStep();
    } else {
        $this->flashMessage('Veuillez choisir une région de naissance correcte.');
    }
}

return $datas;
