<?php

namespace CorahnRin\CharactersBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//use CorahnRin\CharactersBundle\Entity\Characters;
use CorahnRin\CharactersBundle\Steps\StepLoader;

class GeneratorController extends Controller
{
    /**
     * @Route("/characters/generate/")
     * @Template("CorahnRinCharactersBundle:Generator:step_base.html.twig")
     */
    public function indexAction() {
        $step = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Steps')->findOneBy(array('step'=>1));
        return $this->redirect($this->generateUrl('corahnrin_characters_generator_step', array('step'=>$step->getStep(),'slug'=>$step->getSlug())));
    }

    /**
     * @Route("/characters/reset/")
     * @Template()
     */
    public function resetAction()
    {
        $session = $this->get('session');
        $session->remove('character');
        $session->remove('step');
        $session->getFlashBag()->add('success', 'Le personnage en cours de création a été réinitialisé !');
        return $this->redirect($this->generateUrl('corahnrin_characters_generator_index'));
    }

    /**
     * @Route("/characters/generate/{step}-{slug}", requirements={"step" = "\d+"})
     * @Template("CorahnRinCharactersBundle:Generator:step_base.html.twig")
     */
    public function stepAction(\CorahnRin\CharactersBundle\Entity\Steps $step) {
        $datas = array();
        $session = $this->get('session');
        $request = $this->getRequest();
        if (!$session->get('character')) {
            //Si le personnage n'existe pas dans la session, on le crée
            $session->set('character', array());
        }
        if (!$session->get('step')){
            //On définit l'étape dans la session si elle n'existe pas
            $session->set('step', 1);
        }
        $className = '\\CorahnRin\\CharactersBundle\\Steps\\_step_'.str_pad($step->getStep(), 2, 0, STR_PAD_LEFT);//Génère un nom de classe possible
        $stepLoader = new StepLoader($this, $session, $request, $step);

        if ($stepLoader->exists()){
            //Si la méthode existe on l'exécute pour lancer l'analyse de l'étape
            $datas = $stepLoader->load();

            if (is_object($datas) && is_a($datas, '\Symfony\Component\HttpFoundation\RedirectResponse')) {
                //Si datas est un objet "RedirectResponse", c'est qu'on a exécuté nextStep()
                $session->set('step', $step->getStep()+1);
                return $datas;
            }
        } else {
            //Si la méthode n'existe pas, alors on a demandé une étape en trop (ou en moins)
            //Dans ce cas, on renvoie une erreur
            $translator = $this->get('translator');
            $translator->translationDomain('error.steps');
            $msg = $translator->translate('L\'étape %step% n\'a pas été trouvée...', array('%step%'=>$step->getStep()));
            $translator->translationDomain();
            throw new \Symfony\Component\Config\Definition\Exception\Exception($msg);
            exit;
        }
        //Étape chargée
        $datas['loaded_step'] = $step;

        //Fichier de la vue de l'étape
        $datas['loaded_step_filename'] =
            'CorahnRinCharactersBundle:Generator:_step_'
            .str_pad($step->getStep(), 2, '0', STR_PAD_LEFT)
            .'_'
            .$step->getSlug()
            .'.html.twig';

        return $datas;
    }

    /**
     * @Template()
     */
    public function menuAction(\CorahnRin\CharactersBundle\Entity\Steps $step = null) {
        $actual_step = (int) $this->get('session')->get('step') ?: 1;
        $steps = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Steps')->findAll();
        $barWidth = count($steps) ? ($actual_step / count($steps) * 100) : 0;
        return array('steps'=>$steps, 'session_step' => $actual_step, 'bar_width' => $barWidth, 'loaded_step' => $step);
    }

    /*-------------------------------------------------------------------------
    ---------------------------------------------------------------------------
    ---------------------------- MÉTHODES INTERNES ----------------------------
    ---------------------------------------------------------------------------
    -------------------------------------------------------------------------*/

    /**
     * Redirige vers l'étape suivante
     */
    public function _nextStep($stepNumber) {
        $step = $this->getDoctrine()->getManager()
            ->getRepository('CorahnRinCharactersBundle:Steps')
            ->findOneBy(array('step' => ($stepNumber + 1) ));
        if ($step) {
            $url = $this->generateUrl(
                'corahnrin_characters_generator_step',
                array(
                    'step'=>$step->getStep(),
                    'slug'=>$step->getSlug(),
                )
            );
            return $this->redirect($url);
        } else {
            $msg = $this->get('corahn_rin_translate')->translate('Mauvaise étape redirigée.');
            throw new \Symfony\Component\Config\Definition\Exception\Exception($msg);
        }
    }

}
