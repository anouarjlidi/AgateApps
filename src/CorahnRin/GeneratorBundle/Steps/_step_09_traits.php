<?php
/**
 * @StepLoader
 * Métier
 */

$traits = $this->em->getRepository('CorahnRinCharactersBundle:Jobs')->findAll(true);

$ways = $this->getStepValue(8);

exit(print_r($ways));

$quality = isset($this->character[$this->stepFullName()]['quality']) ? (int) $this->character[$this->stepFullName()]['quality'] : null;
$flaw = isset($this->character[$this->stepFullName()]['flaw']) ? (int) $this->character[$this->stepFullName()]['flaw'] : null;

$datas = array(
    'quality' => $quality,
    'flaw' => $flaw,
    'traits_list' => $traits,
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $quality = (int) $this->request->request->get('trait_quality');
    $flaw = (int) $this->request->request->get('trait_flaw');

	$traits_exists = array_key_exists($traits, $quality) && array_key_exists($traits, $flaw);

    if ($trait_exists) {
        $this->characterSet(array(
            'quality' => $quality,
            'flaw' => $flaw,
        ));
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('Les traits de caractère choisis sont incorrects.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;