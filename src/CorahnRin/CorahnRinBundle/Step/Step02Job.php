<?php

namespace CorahnRin\CorahnRinBundle\Step;

class Step02Job extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $jobs = $this->em->getRepository('CorahnRinBundle:Jobs')->findAllPerBook();

        if ($this->request->isMethod('POST')) {
            $jobValue  = (int) $this->request->request->get('job_value');
            $jobExists = false;

            foreach ($jobs as $id => $jobs_list) {
                if (isset($jobs_list[$jobValue])) {
                    $jobExists = true;
                }
            }

            if ($jobExists) {
                $this->updateCharacterStep($jobValue);

                return $this->nextStep();
            } else {
                $this->flashMessage('Veuillez entrer un métier correct.');
            }
        }

        return $this->renderCurrentStep([
            'jobs_list' => $jobs,
            'job_value' => $this->getCharacterProperty(),
        ]);
    }
}
