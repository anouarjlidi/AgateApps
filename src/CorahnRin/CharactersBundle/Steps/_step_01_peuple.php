<?php
/**
 * Peuple
 */

$datas = array();
$t = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:People')->findAll();
$peoples = array();
foreach ($t as $v) { $peoples[$v->getId()] = $v; }
unset($t);
$datas['peoples'] = $peoples;
$datas['people_value'] = '';

$character_people = $session->get('character.people');
if ($character_people) {
    $datas['people_value'] = $character_people;
}

if ($request->isMethod('POST')) {
    $people_id = $request->request->get('gen-div-choice');
    if (isset($peoples[$people_id])) {
        $session->set('character.people', $people_id);
        return $controller->_nextStep($session, $request);
    } else {
        $msg = $controller->get('corahn_rin_translate')->translate('Veuillez indiquer un peuple correct');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;