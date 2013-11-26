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

$character = $session->get('generator_character');
if ($character->getPeople()) {
    $datas['people_value'] = $character->getPeople()->getId();
}

if ($request->isMethod('POST')) {
    $people_id = $request->request->get('gen-div-choice');
    if (isset($peoples[$people_id])) {
        $character->setPeople($peoples[$people_id]);
        $session->set('generator_character', $character);
        return $controller->_nextStep($session, $request);
    } else {
        $msg = $controller->get('corahn_rin_translate')->translate('Veuillez indiquer un peuple correct');
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;