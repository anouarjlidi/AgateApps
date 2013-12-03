<?php
/**
 * Lieu de naissance
 */

$regions = $controller->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Regions')->findAll(true);

$datas['regions_list'] = $regions;
$datas['region_value'] = '';

$character_region = $session->get('character.region');

if ($character_region) {
    $datas['region_value'] = $character_region;
}

if ($request->isMethod('POST')) {
    $region_value = $request->request->get('region_value');
    if (isset($regions[$region_value])) {
        $session->set('character.region', $region_value);
        return $controller->_nextStep($session, $request);
    } else {
        $translator = $controller->get('corahn_rin_translate');
        $translator->routeTemplate('corahnrin_characters_generator_step');
        $msg = $translator->translate('Une erreur est survenue : mauvais contenu envoyé au personnage');
        $translator->routeTemplate();
        $session->getFlashBag()->add('error', $msg);
    }

}
return $datas;