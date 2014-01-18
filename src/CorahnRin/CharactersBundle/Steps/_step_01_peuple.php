<?php
/**
 * Peuple
 */

$peoples = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:People')->findAll(true);

$datas = array(
    'peoples' => $peoples,
    'people_value' => (isset($character[$this->stepFullName()]) ? (int) $character[$this->stepFullName()] : null),
);

if ($request->isMethod('POST')) {
    $people_id = (int) $request->request->get('gen-div-choice');
    if (isset($peoples[$people_id])) {
        $character[$this->stepFullName()] = $people_id;
        $session->set('character', $character);
        return $controller->_nextStep($this->step);
    } else {
        $msg = $controller->get('translator')->trans('Veuillez indiquer un peuple correct.', array(), 'error.steps');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;