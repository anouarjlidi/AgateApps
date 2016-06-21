<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step05 extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $allSocialClasses = $this->em->getRepository('CorahnRinBundle:SocialClasses')->findAll(true);

        $currentStepCharacterValue = $this->getCharacterProperty($this->step->getName());

        $selectedDomains = isset($currentStepCharacterValue['domains']) ? $currentStepCharacterValue['domains'] : [];

        $domainId1 = (int) array_shift($selectedDomains);
        $domainId2 = (int) array_shift($selectedDomains);

        $socialClassId = isset($currentStepCharacterValue['id']) ? $currentStepCharacterValue['id'] : null;

        if ($this->request->isMethod('POST')) {
            $socialClassId   = (int) $this->request->request->get('gen-div-choice');
            $selectedDomains = $this->request->request->get('domains') ?: [];

            $domainId1 = (int) array_shift($selectedDomains);
            $domainId2 = (int) array_shift($selectedDomains);

            if (
                $socialClassId && $domainId1 && $domainId2
                && isset($allSocialClasses[$socialClassId])
            ) {

                $error = false;

                // Let's check that the two chosen domains are really available in this social class
                $socialClass = $allSocialClasses[$socialClassId];
                dump($socialClass);exit;
                foreach ($socialClassDomains as $id => $value) {
                    if ($value !== 'on' && !$socialClass->findDomainById($id)) {
                        $error = true;
                    }
                }

                // S'il y a une erreur c'est que l'un des domaines n'est pas associé à la classe sociale choisie.
                if ($error) {
                    $this->flashMessage('Les domaines choisis ne sont pas associés à la classe sociale sélectionnée.');
                } else {
                    $this->characterSet([
                        'id'      => $socialClassId,
                        'domains' => array_combine(array_keys($socialClassDomains), array_keys($socialClassDomains)),
                    ]);

                    return $this->nextStep();
                }
            } else {

                dump($socialClassId ,$domainId1 ,$domainId2);
                exit;
                // ERREURS
                if (!isset($allSocialClasses[$socialClassId])) {
                    $this->flashMessage('Veuillez sélectionner une classe sociale valide.');
                } elseif (count($socialClassDomains) != 2) {
                    $this->flashMessage('Vous devez choisir 2 domaines pour lesquels vous obtiendrez un bonus de +1. Ces domaines doivent être choisi dans la classe sociale sélectionnée.', 'warning');
                } elseif (!isset($socialClassDomains[$socialClassId])) {
                    $this->flashMessage('Les domaines choisis ne sont pas associés à la classe sociale sélectionnée.');
                }
            }
        }

        return $this->renderCurrentStep([
            'socialClasses'      => $allSocialClasses,
            'socialClass_value'  => $socialClassId,
            'socialClassDomains' => $selectedDomains,
        ]);
    }
}
