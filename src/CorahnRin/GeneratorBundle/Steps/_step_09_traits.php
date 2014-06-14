<?php
/**
 * Traits de caractère
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$global_list = $this->em->getRepository('CorahnRinModelsBundle:Avantages')->findAllDifferenciated($ways);

$advantages = isset($this->character[$this->stepFullName()]['advantages']) ? (int) $this->character[$this->stepFullName()]['advantages'] : array();
$disadvantages = isset($this->character[$this->stepFullName()]['disadvantages']) ? (int) $this->character[$this->stepFullName()]['disadvantages'] : array();

$datas = array(
    'advantages' => $advantages,
    'disadvantages' => $disadvantages,
    'advantages_list' => $global_list['advantages'],
    'disadvantages_list' => $global_list['disadvantages'],
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $advantages_selected = $this->request->request->get('advantages');
    $disadvantages_selected = $this->request->request->get('disadvantages');

    $error = false;

    foreach($advantages_selected as $id => $value) {
        //
    }

    if ($quality_exists && $flaw_exists) {
        $this->characterSet(array(
            'advantages' => $advantages,
            'disadvantages' => $disadvantages,
        ));
        return $this->nextStep();
    } else {
        $this->flashMessage('Une erreur est survenue dans la sélection d\'avantages ou de désavantages.', 'error.steps');
    }

}
return $datas;