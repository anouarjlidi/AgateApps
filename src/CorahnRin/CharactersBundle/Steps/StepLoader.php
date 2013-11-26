<?php
namespace CorahnRin\CharactersBundle\Steps;

/**
 * Charge les étapes pour le contrôleur
 * D'après un nom de fichier dépendant de l'étape injectée
 * @author Alex "Pierstoval" <pierstoval@gmail.com>
 */
class StepLoader {

    private $controller;
    private $session;
    private $request;
    private $step;
    private $filename;

    function __construct($controller, $session, $request, $step) {
        $this->controller = $controller;
        $this->session = $session;
        $this->request = $request;
        $this->filename = __DIR__.'\\'.'_step_'.str_pad($step->getId(), 2, 0, STR_PAD_LEFT).'_'.$step->getSlug().'.php';
    }

    /**
     * Vérifie si le fichier de l'étape existe
     * @return boolean
     */
    public function exists() {
        return file_exists($this->filename);
    }

    /**
     * Exécute _load_alias()
     * @see StepLoader::_load_alias()
     * @return array|object
     */
    public function load() {
        return $this->_load_alias($this->controller, $this->session, $this->request, $this->step);
    }

    /**
     * Exécute le fichier php existant et renvoie sa réponse
     *
     * La réponse peut être un array :<br />
     *  Dans ce cas, c'est la vue twig qui sera chargée, et on enverra le tableau en guise de variables
     * Si la réponse est un objet, c'est un objet RedirectResponse<br />
     *  Dans ce cas, on redirige, soit vers l'étape suivante, soit vers une autre page
     *
     * @param type $controller Le contrôleur qui a exécuté cette fonction
     * @param type $session La session en cours
     * @param type $request La requête en cours
     * @param type $step L'étape récupérée dans la base de données
     * @return type
     */
    private function _load_alias($controller, $session, $request, $step) {
        return require $this->filename;
    }

}