<?php
/**
 * Traits de caractère
 *
 * @var $this CorahnRin\CorahnRinBundle\Steps\StepLoader
 */

$global_list = $this->em->getRepository('CorahnRinModelsBundle:Avantages')->findAllDifferenciated();

$current_xp = 100;

$this->getStepValue();
$advantages = isset($this->character[$this->stepFullName()]['advantages'])
    ? $this->character[$this->stepFullName()]['advantages']
    : array();
$disadvantages = isset($this->character[$this->stepFullName()]['disadvantages'])
    ? $this->character[$this->stepFullName()]['disadvantages']
    : array();

foreach ($advantages as $id => $value) {
    if ($value == 1) {
        $current_xp -= $global_list['advantages'][$id]->getXp();
    } elseif ($value == 2) {
        $current_xp -= (int) ($global_list['advantages'][$id]->getXp() * 1.5);
    }
}
foreach ($disadvantages as $id => $value) {
    if ($id == 50) {
        // Cas particulier du désavantage "Traumatisme"
        $current_xp += $value * $global_list['disadvantages'][$id]->getXp();
    } else {
        if ($value == 1) {
            $current_xp += $global_list['disadvantages'][$id]->getXp();
        } elseif ($value == 2) {
            $current_xp += (int) ($global_list['disadvantages'][$id]->getXp() * 1.5);
        }
    }
}

$datas = array(
    'current_xp' => $current_xp,
    'advantages' => $advantages,
    'disadvantages' => $disadvantages,
    'advantages_list' => $global_list['advantages'],
    'disadvantages_list' => $global_list['disadvantages'],
);

if ($this->request->isMethod('POST')) {
    $advantages_selected = $this->request->request->get('advantages');
    $disadvantages_selected = $this->request->request->get('disadvantages');

    $error = false;

    if (count($this->request->request->all())) {
        \CorahnRinTools\pr($this->request->request->all());exit;
    }

    foreach ($advantages_selected as $id => $value) {
        if (
            !isset($advantages[$id])
            || !is_numeric($id)
            || !is_numeric($value)
            || $advantages[$id]->getAugmentation() < $value
        ) {
            $error = true;
            break;
        }
    }

    if (false === $error) {
        $this->characterSet(array(
            'advantages' => $advantages_selected,
            'disadvantages' => $disadvantages_selected,
        ));
        return $this->nextStep();
    } else {
        $this->flashMessage('Une erreur est survenue dans la sélection d\'avantages ou de désavantages.', 'error.steps');
    }

}
return $datas;