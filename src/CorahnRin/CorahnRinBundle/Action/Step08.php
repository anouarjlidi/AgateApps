<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step08 extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        return $this->renderCurrentStep([
            'ways_list' => [],
        ]);
    }
}
