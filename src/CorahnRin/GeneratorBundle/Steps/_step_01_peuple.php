<?php
/**
 * Peuple
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$peoples = $this->em->getRepository('CorahnRinModelsBundle:Peoples')->findAll(true);

$datas = array(
    'peoples' => $peoples,
    'people_value' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null),
);

if ($this->request->isMethod('POST')) {
    $people_id = (int) $this->request->request->get('gen-div-choice');
    if (isset($peoples[$people_id])) {
        $this->characterSet($people_id);
        return $this->nextStep();
    } else {
        $this->flashMessage('Veuillez indiquer un peuple correct.');
    }

}
return $datas;