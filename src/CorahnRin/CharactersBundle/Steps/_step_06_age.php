<?php
/**
 * Peuple
 */

$datas = array(
    'age' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : 16),
);

if ($this->request->isMethod('POST')) {
    $age = (int) $this->request->request->get('age');
    if (16 <= $age && $age <= 35) {
        $this->character[$this->stepFullName()] = $age;
        $this->session->set('character', $this->character);
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('L\'âge doit être compris entre 16 et 35 ans.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;