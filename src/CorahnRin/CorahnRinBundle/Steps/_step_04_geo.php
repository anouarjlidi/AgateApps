<?php
/**
 * Lieu de résidence géographique.
 *
 * @var $this CorahnRin\CorahnRinBundle\Steps\StepLoader
 */
$geoEnvironments = $this->em->getRepository('CorahnRinBundle:GeoEnvironments')->findAll(true);

$datas = array(
    'geoEnvironments' => $geoEnvironments,
    'geoEnvironment_value' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null),
);

if ($this->request->isMethod('POST')) {
    $geoEnvironment_id = (int) $this->request->request->get('gen-div-choice');
    if (isset($geoEnvironments[$geoEnvironment_id])) {
        $this->characterSet($geoEnvironment_id);

        return $this->nextStep();
    } else {
        $this->flashMessage('Veuillez indiquer un peuple correct.');
    }
}

return $datas;
