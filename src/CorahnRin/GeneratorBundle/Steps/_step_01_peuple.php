<?php
/**
 * Peuple
 */

$peoples = $this->em->getRepository('CorahnRinCharactersBundle:Peoples')->findAll(true);

$datas = array(
    'peoples' => $peoples,
    'people_value' => (isset($this->character[$this->stepFullName()]) ? (int) $this->character[$this->stepFullName()] : null),
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $people_id = (int) $this->request->request->get('gen-div-choice');
    if (isset($peoples[$people_id])) {
        $this->character[$this->stepFullName()] = $people_id;
        $this->session->set('character', $this->character);
        return $this->nextStep();
    } else {
        $msg = $this->controller->get('translator')->trans('Veuillez indiquer un peuple correct.', array(), 'error.steps');
        $this->session->getFlashBag()->add('error', $msg);
    }

}
return $datas;