<?php
/**
 * Voies
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$ways = $this->em->getRepository('CorahnRinModelsBundle:Ways')->findAll(true);

$ways_values = isset($this->character[$this->stepFullName()]) ? $this->character[$this->stepFullName()] : null;
if (null === $ways_values) {
    foreach ($ways as $id => $way) {
        $ways_values[$id] = 1;
    }
}

$datas = array(
    'ways_values' => $ways_values,
    'ways_list' => $ways,
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $ways_values = (array) $this->request->request->get('ways');

    $sum = 0;

    foreach ($ways_values as $id => $value) {
        $value = (int) $value;
        if (!array_key_exists($id,$ways)) {
            $this->flashMessage('Erreur dans le formulaire. Merci de vérifier les valeurs soumises.');
            return $datas;
        }
        if ($value <= 0 || $value > 5) {
            $this->flashMessage('Les voies doivent être comprises entre 1 et 5.');
            return $datas;
        }
        $sum += $value;
    }

    if ($sum !== 15) {
        $this->flashMessage('La somme des voies doit être égale à 15. Merci de corriger les valeurs de certaines voies.');
        return $datas;
    }

    $this->characterSet($ways_values);
    return $this->nextStep();
}
return $datas;