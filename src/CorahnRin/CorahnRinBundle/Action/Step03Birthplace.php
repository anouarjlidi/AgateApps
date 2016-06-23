<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step03Birthplace extends AbstractStepAction
{
    /**
     * @var int
     */
    private $tileSize;

    public function __construct($tileSize)
    {
        $this->tileSize = $tileSize;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $regions = $this->em->getRepository('EsterenMapsBundle:Zones')->findAll(true);

        // Hardcoded here, it's base esteren map.
        $map = $this->em->getRepository('EsterenMapsBundle:Maps')->find(1);

        if ($this->request->isMethod('POST')) {
            $regionValue = (int) $this->request->request->get('region_value');
            if (isset($regions[$regionValue])) {
                $this->updateCharacterStep($regionValue);

                return $this->nextStep();
            } else {
                $this->flashMessage('Veuillez choisir une région de naissance correcte.');
            }
        }

        return $this->renderCurrentStep([
            'map'          => $map,
            'tile_size'    => $this->tileSize,
            'regions_list' => $regions,
            'region_value' => $this->getCharacterProperty(),
        ]);
    }
}
