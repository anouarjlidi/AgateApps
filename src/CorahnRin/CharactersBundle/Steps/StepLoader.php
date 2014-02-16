<?php
namespace CorahnRin\CharactersBundle\Steps;

use CorahnRin\CharactersBundle\Entity\Steps;

/**
 * Charge les étapes pour le contrôleur
 * D'après un nom de fichier dépendant de l'étape injectée
 * @author Alex "Pierstoval" <pierstoval@gmail.com>
 */
class StepLoader {

    private $controller;
    private $session;
    private $character;
    private $request;
    private $step;
    private $filename;

    function __construct($controller, $session, $request, $step) {
        $this->controller = $controller;
        $this->session = $session;
        $this->request = $request;
        $this->stepEntity = $step;
        $this->step = $step->getStep();
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
     * Retourne le nom complet de l'étape : {step}.{slug}
     * @return string
     */
    public function stepFullName(Steps $step = null) {
        if (null === $step) { $step = $this->stepEntity; }
        return $step->getStep().'.'.$step->getSlug();
    }

    /**
     * Redirige à l'étape suivante
     * @return array|object
     */
    public function nextStep() {
        return $this->controller->_goToStep($this->step + 1);
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

}