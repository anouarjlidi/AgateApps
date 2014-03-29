<?php
/**
 * Métier
 */

$setbacks = $this->em->getRepository('CorahnRinCharactersBundle:Setbacks')->findAll(true);

$setback_value = $this->getStepValue() ?: array();

$age = $this->getStepValue(6);

// Cette variable permettra d'indiquer à l'appli que l'utilisateur peut choisir les revers ou non
// Il est prévu qu'on autorise l'utilisateur à choisir ses revers dans certaines conditions uniquement.
$choice_available = false;

$nb_revers = 0;
if ($age > 20) { $nb_revers ++; }
if ($age > 25) { $nb_revers ++; }
if ($age > 30) { $nb_revers ++; }

if (!$nb_revers && !$setback_value && !$choice_available) {
    // Cas où aucun revers n'est assigné (âge < 21 ans)
    $this->characterSet(array());

} elseif ($nb_revers && !$setback_value && !$choice_available) {
    // Dans le cas où l'utilisateur n'a pas la possibilité de choisir ses revers,
    // ils vont être déterminés par un jet automatique.

    // Reset des clés du tableau, pour que la liste soit ordonnée correctement
    $setbacks_dice_list = array_values($setbacks);

    $loop_nb = $nb_revers;
    while ($loop_nb > 0) {
        // On force le reset de toutes les clés du tableau
        $setbacks_dice_list = array_values($setbacks_dice_list);

        // On lance le dé (pas forcément un d10, car on pourra ajouter des revers à l'avenir)
        $dice = rand(0, (count($setbacks_dice_list) - 1));
        $chosen = $setbacks_dice_list[$dice];

        if ($chosen->getId() == 1) {
            // Poisse !
            unset($setbacks_dice_list[$dice]);// On désactive "Poisse" pour ne pas l'obtenir à nouveau
            $setbacks_dice_list = array_values($setbacks_dice_list);

            $setback_value[$chosen->getId()] = array('id' => $chosen->getId(),'avoided'=>false);// On l'ajoute aux revers

            // Et on relance le dé !
            $dice = rand(0, (count($setbacks_dice_list) - 1));
            $chosen = $setbacks_dice_list[$dice];
            unset($setbacks_dice_list[$dice]);// On désactive le nouveau revers pioché
            $setback_value[$chosen->getId()] = array('id' => $chosen->getId(),'avoided'=>false);// Et on l'ajoute aux revers du personnage

        } elseif ($chosen->getId() == 10) {
            // Chance !
            unset($setbacks_dice_list[$dice]);// On désactive "Chance" pour ne pas l'obtenir à nouveau
            $setbacks_dice_list = array_values($setbacks_dice_list);

            $setback_value[$chosen->getId()] = array('id' => $chosen->getId(),'avoided'=>false);// On l'ajoute aux revers du personnage
            //
            // Et on relance le dé pour savoir quel revers a été évité par chance
        $dice = rand(0, (count($setbacks_dice_list) - 1));
            $chosen = $setbacks_dice_list[$dice];
            unset($setbacks_dice_list[$dice]);// On désactive le nouveau revers pioché
            $setbacks_dice_list = array_values($setbacks_dice_list);

            $setback_value[$chosen->getId()] = array('id' => $chosen->getId(),'avoided'=>true);// Et on l'ajoute aux revers, en spécifiant bien qu'il a été évité

        } else {
            // Si le revers tiré n'est ni "Chance" ni "Poisse", on l'ajoute normalement.
            unset($setbacks_dice_list[$dice]);// On désactive le nouveau revers pioché
            $setbacks_dice_list = array_values($setbacks_dice_list);
            $setback_value[$chosen->getId()] = array('id' => $chosen->getId(),'avoided'=>false);// Et on l'ajoute aux revers du personnage

        }
        $loop_nb --;
    }
    $this->characterSet($setback_value);
}

$datas = array(
    'setbacks_count' => $nb_revers,
    'age' => $age,
    'setback_value' => $setback_value,
    'setbacks_list' => $setbacks,
    'choice_available' => $choice_available,
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();

    if ($choice_available) {
        $setback_value = (int) $this->request->request->get('setback_value');
        $setback_exists = false;

        foreach ($setbacks as $id => $setbacks_list) {
            if (isset($setbacks_list[$setback_value])) { $setback_exists = true; }
        }

        if ($setback_exists) {
            $this->characterSet($setback_value);
            return $this->nextStep();
        } else {
            $msg = $this->controller->get('translator')->trans('Veuillez entrer un métier correct.', array(), 'error.steps');
            $this->session->getFlashBag()->add('error', $msg);
        }
    } else {
        return $this->nextStep();
    }

}
return $datas;