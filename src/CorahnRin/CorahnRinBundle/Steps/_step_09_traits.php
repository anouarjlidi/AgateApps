<?php
/**
 * Traits de caractère.
 *
 * @var $this CorahnRin\CorahnRinBundle\Steps\StepLoader
 */
$ways = $this->getStepValue(8);

$traits = $this->em->getRepository('CorahnRinBundle:Traits')->findAllDependingOnWays($ways);

$quality = isset($this->character[$this->stepFullName()]['quality']) ? (int) $this->character[$this->stepFullName()]['quality'] : null;
$flaw    = isset($this->character[$this->stepFullName()]['flaw']) ? (int) $this->character[$this->stepFullName()]['flaw'] : null;

$datas = [
    'quality'     => $quality,
    'flaw'        => $flaw,
    'traits_list' => $traits,
];

if ($this->request->isMethod('POST')) {
    $quality = (int) $this->request->request->get('quality');
    $flaw    = (int) $this->request->request->get('flaw');

    $quality_exists = array_key_exists($quality, $traits['qualities']);
    $flaw_exists    = array_key_exists($flaw, $traits['flaws']);

    if ($quality_exists && $flaw_exists) {
        $this->characterSet([
            'quality' => $quality,
            'flaw'    => $flaw,
        ]);

        return $this->nextStep();
    } else {
        $this->flashMessage('Les traits de caractère choisis sont incorrects.', 'error.steps');
    }
}

return $datas;
