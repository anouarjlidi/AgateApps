<?php
/**
 * Age
 * @var $this CorahnRin\GeneratorBundle\Steps\StepLoader
 */

$datas = array(
    'age' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : 16),
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $age = (int) $this->request->request->get('age');
    if (16 <= $age && $age <= 35) {
        $this->characterSet($age);
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('L\'âge doit être compris entre 16 et 35 ans.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;