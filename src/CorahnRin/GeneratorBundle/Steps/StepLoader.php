<?php
namespace CorahnRin\GeneratorBundle\Steps;

use CorahnRin\GeneratorBundle\Entity\Steps;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Charge les étapes pour le contrôleur, d'après un nom de fichier dépendant de l'étape injectée
 * @author Alex "Pierstoval" <pierstoval@gmail.com>
 * @version 1.0 27/12/2013
 * @version 1.1 16/03/2014 Injection de la liste des étapes dans le loader. Ajout de quelques méthodes pour faciliter la gestion des étapes et de la session.
 */
class StepLoader {

    private $controller;
    private $em;
    private $session;
    private $character;
    private $request;
    private $filename;
    private $step;
    private $steps;
    public $stepEntity;

    function __construct(Controller $controller, SessionInterface $session, Request $request, Steps $step, $steps) {
        $this->controller = $controller;
        $this->em = $controller->getDoctrine()->getManager();
        $this->session = $session;
        $this->request = $request;
        $this->stepEntity = $step;
        $this->step = $step->getStep();
        $this->steps = $steps;
        $this->filename = __DIR__.'/'.'_step_'.str_pad($step->getId(), 2, 0, STR_PAD_LEFT).'_'.$step->getSlug().'.php';
        $this->character = $session->get('character');
    }

    /**
     * Vérifie si le fichier de l'étape existe
     * @return boolean
     */
    public function exists() {
        return file_exists($this->filename);
    }

    /**
     * Récupère une étape à partir du numéro de l'étape demandée
     *
     * @param object|int $step
     * @return \CorahnRin\GeneratorBundle\Entity\Steps
     * @throws \Exception
     */
    public function getStep($step = null) {
        if (null === $step) { $step = $this->stepEntity; }
        if (is_numeric($step)) {
            if (array_key_exists($step, $this->steps)) {
                $step = $this->steps[$step];
            } else {
                throw new \Exception('Step not found in StepLoader\'s steps list.');
            }
        }
        return $step;
    }

    /**
     * Retourne le nom complet de l'étape : {step}.{slug}
     * @return string
     */
    public function stepFullName($step = null) {
        $step = $this->getStep($step);
        return $step->getStep().'.'.$step->getSlug();
    }

    /**
     * Renvoie la valeur de l'étape demandée dans le personnage en session.
     * Renvoie null si la clé n'existe pas
     * @param object|int $step
     * @return mixed
     */
    public function getStepValue($step = null) {
        $step = $this->getStep($step);
        $stepFullName = $this->stepFullName($step);
        return array_key_exists($stepFullName, $this->character)
                ? $this->character[$stepFullName]
                : null;
    }

    /**
     * Redirige à l'étape suivante
     * @return array|object
     */
    public function nextStep() {
        return $this->controller->_goToStep($this->step + 1);
    }

    /**
     * Supprime de la session les valeurs qui dépendent de l'étape en cours
     */
    public function resetSteps() {
        foreach ($this->stepEntity->getStepsToDisableOnChange() as $s) {
            unset($this->character[$this->stepFullName($s)]);
        }
    }

    /**
     * Exécute le fichier php existant et renvoie sa réponse
     *
     * La réponse peut être un array :<br />
     *  Dans ce cas, c'est la vue twig qui sera chargée, et on enverra le tableau en guise de variables
     * Si la réponse est un objet, c'est un objet RedirectResponse<br />
     *  Dans ce cas, on redirige, soit vers l'étape suivante, soit vers une autre page
     *
     * @return array|object
     */
    public function load() {

        // Initialisation des variables du scope local

        // Chargement du fichier, les variables précédentes y seront utilisables
        return require $this->filename;
    }

    /**
     * Crée une erreur "flash"
     *
     * @param string $msg
     * @param string $type
     * @param array $msgParams
     */
    public function flashMessage($msg, $type = 'error', $msgParams = array()) {
        $msg = $this->controller->get('translator')->trans($msg, $msgParams, 'error.steps');
        $this->session->getFlashBag()->add($type, $msg);
    }
}