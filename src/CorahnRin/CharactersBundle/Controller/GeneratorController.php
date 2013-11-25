<?php

namespace CorahnRin\CharactersBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CorahnRin\CharactersBundle\Entity\Characters;

class GeneratorController extends Controller
{
    /**
     * @Route("/characters/generate/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/characters/reset/")
     * @Template()
     */
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('generator_character', null);
        $session->set('step', 1);
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
        if (!$session->get('generator_character')) {
            //Si le personnage n'existe pas dans la session, on le crée
            $session->set('generator_character', new Characters());
        }
        if (!$session->get('step')){
            //On définit l'étape dans la session si elle n'existe pas
            $session->set('step', 1);
        }
        if (method_exists($this, '_stepView'.$step->getStep())){
            //Si la méthode existe on l'exécute pour lancer l'analyse de l'étape
            $datas = $this->{'_stepView'.$step->getStep()}($session, $request);

            if (is_object($datas) && is_a($datas, '\Symfony\Component\HttpFoundation\RedirectResponse')) {
                //Si datas est un objet "RedirectResponse", c'est qu'on a exécuté nextStep()
                $session->set('step', $step->getStep()+1);
                return $datas;
            }
        } else {
            //Si la méthode n'existe pas, alors on a demandé une étape en trop (ou en moins)
            //Dans ce cas, on renvoie une erreur
            $translator = $this->get('corahnrin_translate');
            $translator->routeTemplate('corahnrin_characters_generator_step');
            $msg = $translator->translate('L\'étape %step% n\'a pas été trouvée...', array('%step%'=>$step->getStep()));
            $translator->routeTemplate();
            throw new \Symfony\Component\Config\Definition\Exception\Exception($msg);
            exit;
        }
        //Étape chargée
        $datas['loaded_step'] = $step;

        //Fichier de la vue de l'étape
        $datas['loaded_step_filename'] = 'CorahnRinCharactersBundle:Generator:_step_'.str_pad($step->getStep(), 2, '0', STR_PAD_LEFT).'_'.$step->getSlug().'.html.twig';

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
    private function _nextStep($session, $request) {
        $step = $session->get('step');
        $step++;
        $repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Steps');
        $step = $repo->findOneBy(array('step'=>$step));
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

    /**
     * Step peuple
     */
    private function _stepView1($session, $request) {

        $datas = array();
        $t = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:People')->findAll();
        $peoples = array();
        foreach ($t as $v) { $peoples[$v->getId()] = $v; }
        unset($t);
        $datas['peoples'] = $peoples;
        $datas['people_value'] = '';

        $character = $session->get('generator_character');
        if ($character->getPeople()) {
            $datas['people_value'] = $character->getPeople()->getId();
        }

        if ($request->isMethod('POST')) {
            $people_id = $request->request->get('gen-div-choice');
            if (isset($peoples[$people_id])) {
                $character->setPeople($peoples[$people_id]);
                $session->set('generator_character', $character);
                return $this->_nextStep($session, $request);
            } else {
                $msg = $this->get('corahn_rin_translate')->translate('Veuillez indiquer un peuple correct');
                $session->getFlashBag()->add('error', $msg);
            }

        }
        return $datas;
    }

    /**
     * Step metier
     */
    private function _stepView2($session, $request) {
        $t = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Jobs')->findAll();
        $jobs = array();
        foreach ($t as $v) { $jobs[$v->getId()] = $v; }
        unset($t);
        $datas['jobs'] = $jobs;
        $datas['jobs_value'] = '';

        $character = $session->get('generator_character');

        if ($character->getJob()) {
            $datas['job_value'] = $character->getJob()->getId();
        } elseif ($character->getJobCustom()) {
            $datas['job_value'] = $character->getJobCustom();
        }

        if ($request->isMethod('POST')) {
            $job_value = $request->request->get('job_value');
            if (isset($peoples[$job_value])) {
                $character->setJob($jobs[$job_value]);
                $session->set('generator_character', $character);
                return $this->_nextStep($session, $request);
            } elseif ($job_value && !is_numeric($job_value)) {
                $character->setJobCustom($job_value);
                $session->set('generator_character', $character);
                return $this->_nextStep($session, $request);
            } else {
                $msg = $this->get('corahn_rin_translate')->translate('Une erreur est survenue : mauvais contenu envoyé au personnage');
                $session->getFlashBag()->add('error', $msg);
            }

        }
        return $datas;
    }
}
