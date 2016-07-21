<?php

namespace CorahnRin\CorahnRinBundle\Step;

use CorahnRin\CorahnRinBundle\Entity\SocialClasses;

class Step05SocialClass extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $allSocialClasses = $this->em->getRepository('CorahnRinBundle:SocialClasses')->findAll(true);

        $currentStepCharacterValue = $this->getCharacterProperty();

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
                // Let's check that the two chosen domains are really available in this social class
                /** @var SocialClasses $socialClass */
                $socialClass = $allSocialClasses[$socialClassId];

                // S'il y a une erreur c'est que l'un des domaines n'est pas associé à la classe sociale choisie.
                if (!$socialClass->hasDomain($domainId1) || !$socialClass->hasDomain($domainId2)) {
                    $this->flashMessage('Les domaines choisis ne sont pas associés à la classe sociale sélectionnée.');
                } else {
                    $this->updateCharacterStep([
                        'id'      => $socialClassId,
                        'domains' => [$domainId1 => $domainId1, $domainId2 => $domainId2],
                    ]);

                    return $this->nextStep();
                }
            } else {
                // Errors
                if (!array_key_exists($socialClassId, $allSocialClasses)) {
                    $this->flashMessage('Veuillez sélectionner une classe sociale valide.');
                } elseif (!$domainId1 || !$domainId2) {
                    $this->flashMessage('Vous devez choisir 2 domaines pour lesquels vous obtiendrez un bonus de +1. Ces domaines doivent être choisi dans la classe sociale sélectionnée.', 'warning');
                }
            }
        }

        return $this->renderCurrentStep([
            'socialClasses'      => $allSocialClasses,
            'socialClass_value'  => $socialClassId,
            'socialClassDomains' => [$domainId1 => $domainId1, $domainId2 => $domainId2],
        ]);
    }
}
