<?php
/**
 * Voies
 *
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$ways = $this->em->getRepository('CorahnRinModelsBundle:Ways')->findAll(true);

$ways_values = isset($this->character[$this->stepFullName()]) ? $this->character[$this->stepFullName()] : null;
if (null === $ways_values) {
    if ($this->request->isMethod('POST')) {
        foreach ($this->request->request->get('ways') as $id => $value) {
            $value = (int) $value;
            if (array_key_exists($id, $ways) && $value >= 1 && $value <= 5) {
                $ways_values[$id] = $value;
            }
        }
    }
    foreach ($ways as $id => $way) {
        if (!isset($ways_values[$id])) {
            $ways_values[$id] = 1;
        }
    }

}

$datas = array(
    'ways_values' => $ways_values,
    'ways_list' => $ways,
);

if ($this->request->isMethod('POST')) {
    $ways_values = (array) $this->request->request->get('ways');

    $error = false;
    $errorWayNotExists = false;
    $errorValueNotInRange = false;
    $sum = 0;
    $has1or5 = false;

    foreach ($ways_values as $id => $value) {
        $value = (int) $value;
        if (!array_key_exists($id, $ways) && false === $errorWayNotExists) {
            $error = true;
            $errorWayNotExists = true;
            $this->flashMessage('Erreur dans le formulaire. Merci de vérifier les valeurs soumises.');
        }
        if (($value <= 0 || $value > 5) && false === $errorValueNotInRange) {
            $error = true;
            $errorValueNotInRange = true;
            $this->flashMessage('Les voies doivent être comprises entre 1 et 5.');
        }
        if ($value == 1 || $value == 5) {
            $has1or5 = true;
        }
        $sum += $value;
    }

    if ($sum !== 15) {
        $error = true;
        if ($sum > 5) {
            $this->flashMessage('La somme des voies doit être égale à 15. Merci de corriger les valeurs de certaines voies.', 'warning');
        } else {
            $this->flashMessage('Veuillez indiquer vos scores de Voies.');
        }
    }
    if (!$has1or5) {
        $error = true;
        $this->flashMessage('Au moins une des voies doit avoir un score de 1 ou de 5.', 'warning');
    }

    if (false !== $error) {
        return $datas;
    }

    $this->characterSet($ways_values);
    return $this->nextStep();
}
return $datas;