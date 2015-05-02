<?php

namespace CorahnRin\CorahnRinBundle\Controller;

use CorahnRin\CorahnRinBundle\Entity\Steps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GeneratorController extends Controller {

    private $steps;

    /**
     * @Route("/characters/generate/", name="corahnrin_generator_generator_index")
     * @Template("CorahnRinBundle:Generator:step_base.html.twig")
     */
    public function indexAction() {
        $step = $this->getDoctrine()->getManager()->getRepository('CorahnRinBundle:Steps')->findOneBy(array('step' => 1));
        return $this->redirect($this->generateUrl('corahnrin_generator_generator_step', array(
            'step' => $step->getStep(),
            'slug' => $step->getSlug()
        )));
    }

    /**
     * @Route("/characters/reset/", name="corahnrin_generator_generator_reset")
     */
    public function resetAction() {
        $session = $this->get('session');
        $session->set('character', array());
        $session->set('step', 1);
        $session->getFlashBag()->add('success', 'Le personnage en cours de création a été réinitialisé !');
        return $this->redirect($this->generateUrl('corahnrin_generator_generator_index'));
    }

    /**
     * @Route("/characters/generate/{step}-{slug}", requirements={"step" = "\d+"}, name="corahnrin_generator_generator_step")
     * @Template("CorahnRinBundle:Generator:step_base.html.twig")
     */
    public function stepAction(Request $request, Steps $step) {

        $session = $this->get('session');

        //Si le personnage n'existe pas dans la session, on le crée
        if (!$session->get('character')) {
            $session->set('character', array());
        }

        $character = $session->get('character');

        $this->steps = $this->steps
            ? : $this->getDoctrine()->getManager()->getRepository('CorahnRinBundle:Steps')->findAll(true, 'step');

        for ($i = 1; $i <= $step->getStep(); $i++) {
            $stepName = $this->steps[$i]->getStep() . '.' . $this->steps[$i]->getSlug();
            if (!array_key_exists($stepName, $character)) {
                if ($step->getStep() > $this->steps[$i]->getStep()) {
                    return $this->_goToStep($this->steps[$i]->getStep());
                }
            }
        }

//        $stepLoader = new StepLoader($this, $session, $request, $step, $this->steps);

        /**
         * @var \CorahnRin\CorahnRinBundle\Steps\StepLoader
         */
        $stepLoader = $this->container->get('corahn_rin_generator.steps_loader');

        $stepLoader->initiate($this, $session, $request, $step, $this->steps);

        if ($stepLoader->exists()) {
            //Si la méthode existe on l'exécute pour lancer l'analyse de l'étape
            $datas = $stepLoader->load();

            if (is_object($datas) && is_a($datas, '\Symfony\Component\HttpFoundation\RedirectResponse')) {
                //Si datas est un objet "RedirectResponse", c'est qu'on a exécuté nextStep() dans le loader
                $session->set('step', $step->getStep() + 1);
                return $datas;
            } else {
                //Étape chargée
                $datas['loaded_step'] = $step;

                //Fichier de la vue de l'étape
                $datas['loaded_step_filename'] =
                    $stepLoader->getViewsDirectory() . ':' .
                    '_step_'
                    . str_pad($step->getStep(), 2, '0', STR_PAD_LEFT)
                    . '_'
                    . $step->getSlug()
                    . '.html.twig';

                return $datas;
            }
        } else {
            //Si la méthode n'existe pas, alors on a demandé une étape en trop (ou en moins)
            //Dans ce cas, on renvoie une erreur
            $msg = $this->container->get('translator')->trans('L\'étape %step% n\'a pas été trouvée...', array('%step%' => $step->getStep()), 'error.steps');
            throw new \Exception($msg);
        }
    }

    /**
     * @Template()
     */
    public function menuAction(Steps $step = null) {
        $actual_step = (int)$this->get('session')->get('step') ? : 1;
        $this->steps = $this->steps
            ? : $this->getDoctrine()->getManager()->getRepository('CorahnRinBundle:Steps')->findAll(true, 'step');
        $barWidth = count($this->steps) ? ($actual_step / count($this->steps) * 100) : 0;
        return array(
            'steps' => $this->steps,
            'session_step' => $actual_step,
            'bar_width' => $barWidth,
            'loaded_step' => $step
        );
    }

    /*-------------------------------------------------------------------------
    ---------------------------------------------------------------------------
    ---------------------------- MÉTHODES INTERNES ----------------------------
    ---------------------------------------------------------------------------
    -------------------------------------------------------------------------*/

    /**
     * Redirige vers une étape
     */
    public function _goToStep($stepNumber) {
        $step = null;
        $step = $this->steps
            ? $this->steps[$stepNumber]
            : $this->getDoctrine()->getManager()
                ->getRepository('CorahnRinBundle:Steps')
                ->findOneBy(array('step' => $stepNumber));

        if ($step) {
            $url = $this->generateUrl(
                'corahnrin_generator_generator_step',
                array(
                    'step' => $step->getStep(),
                    'slug' => $step->getSlug(),
                )
            );
            $this->get('session')->set('step', $step->getStep());
            return $this->redirect($url);
        } else {
            $msg = $this->get('corahn_rin_translate')->translate('Mauvaise étape redirigée.', array(), 'error.steps');
            throw new \Exception($msg);
        }
    }

}