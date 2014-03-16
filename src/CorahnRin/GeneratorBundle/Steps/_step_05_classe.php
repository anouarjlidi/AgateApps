<?php
/**
 * Peuple
 */

$socialClasses = $this->em->getRepository('CorahnRinCharactersBundle:SocialClasses')->findAll(true);

$socialClassesDomains = (isset($this->character[$this->stepFullName()]['domains']) ? $this->character[$this->stepFullName()]['domains'] : array());

$socialClass_value = (isset($this->character[$this->stepFullName()]['id']) ? (int) $this->character[$this->stepFullName()]['id'] : null);

$datas = array(
    'socialClasses' => $socialClasses,
    'socialClass_value' => $socialClass_value,
    'socialClassDomains' => $socialClassesDomains,
);

if ($this->request->isMethod('POST')) {
    $this->resetSteps();
    $socialClass_value = (int) $this->request->request->get('gen-div-choice');
    $socialClassDomains = $this->request->request->get('domains');

    if (isset($socialClasses[$socialClass_value]) && isset($socialClassDomains[$socialClass_value]) && count($socialClassDomains[$socialClass_value]) == 2) {

        // On "rapetisse" le tableau
        $socialClassDomains = $socialClassDomains[$socialClass_value];

        $error = false;

        // On va vérifier que les deux domaines choisis sont bien associés à cette classe sociale
        $socialClass = $socialClasses[$socialClass_value];
        foreach ($socialClassDomains as $id => $value) {
            if ($value !== 'on' && !$socialClass->findDomainById($id)) {
                $error = true;
            }
        }

        // S'il y a une erreur c'est que l'un des domaines n'est pas associé à la classe sociale choisie.
        if ($error) {
            $msg = $this->controller->get('translator')->trans('Les domaines choisis ne sont pas associés à la classe sociale sélectionnée.', array(), 'error.steps');
            $this->session->getFlashBag()->add('error', $msg);
        } else {

            $this->character[$this->stepFullName()]['id'] = $socialClass_value;
            $this->character[$this->stepFullName()]['domains'] = array_combine(array_keys($socialClassDomains), array_keys($socialClassDomains));
            $this->session->set('character', $this->character);
            return $this->nextStep();
        }

    } else {

        // ERREURS

        if (!isset($socialClasses[$socialClass_value])) {
            $msg = $this->controller->get('translator')->trans('Classe sociale non trouvée.', array(), 'error.steps');
            $this->session->getFlashBag()->add('error', $msg);
        } elseif (count($socialClassDomains) != 2) {
            $msg = $this->controller->get('translator')->trans('Vous devez choisir 2 domaines pour lesquels vous obtiendrez un bonus de +1. Ces domaines doivent être choisi dans la classe sociale sélectionnée.', array(), 'error.steps');
            $this->session->getFlashBag()->add('info', $msg);
        } elseif (!isset($socialClassDomains[$socialClass_value])) {
            $msg = $this->controller->get('translator')->trans('Les domaines choisis ne sont pas associés à la classe sociale sélectionnée.', array(), 'error.steps');
            $this->session->getFlashBag()->add('error', $msg);
        }
    }

}
return $datas;