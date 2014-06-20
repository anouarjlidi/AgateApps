<?php
/**
 * Orientation de la personnalité
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$orientation = $this->getStepValue();

$orientations = array(
    'instinctive' => array(
        'name' => 'Instinctive',
        'description' => 'L\'Instinct concerne toute l\'énergie pulsionnelle d\'un être vivant. Cet Aspect regroupe notamment les instincts de survie et d\'autoconservation ainsi que tout ce qui a trait à la sexualité.',
    ),
    'rational' => array(
        'name' => 'Rationnelle',
        'description' => 'Cet Aspect rend compte de l\'importance de la rationalité pour le PJ, de son ancrage dans la réalité, de sa capacité de logique et de réflexion, et de sa solidité.',
    ),
);

$ways = $this->getStepValue(8);

$com = $ways[1];
$cre = $ways[2];
$rai = $ways[4];
$ide = $ways[5];

$conscience = $rai + $ide;
$instinct = $com + $cre;

$can_be_changed = false;

if ($conscience > $instinct) {
    $orientation = 'rational';
} elseif ($instinct > $conscience) {
    $orientation = 'instinctive';
} else {
    $can_be_changed = true;
}

$datas = array(
    'can_be_changed' => $can_be_changed,
    'orientation_value' => $orientation,
    'orientations' => $orientations,
);

if ($this->request->isMethod('POST')) {
    $orientation = $this->request->request->get('gen-div-choice');

    $orientation_exists = array_key_exists($orientation, $orientations);

    if ($orientation_exists) {
        $this->characterSet($orientation);
        return $this->nextStep();
    } else {
        $this->flashMessage('L\'orientation de la personnalité est incorrecte, veuillez vérifier.', null, 'error');
    }

}
return $datas;