<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step02Job extends AbstractStepAction
{

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $jobs = $this->em->getRepository('CorahnRinBundle:Jobs')->findAllPerBook();

        if ($this->request->isMethod('POST')) {
            $job_value  = (int) $this->request->request->get('job_value');
            $job_exists = false;

            foreach ($jobs as $id => $jobs_list) {
                if (isset($jobs_list[$job_value])) {
                    $job_exists = true;
                }
            }

            if ($job_exists) {
                $this->updateCharacterStep($job_value);

                return $this->nextStep();
            } else {
                $this->flashMessage('Veuillez entrer un métier correct.');
            }
        }

        return $this->renderCurrentStep([
            'jobs_list' => $jobs,
            'job_value' => $this->getCharacterProperty($this->step->getName()),
        ]);
    }
}
