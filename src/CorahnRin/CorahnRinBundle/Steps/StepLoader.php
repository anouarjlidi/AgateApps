<?php

namespace CorahnRin\CorahnRinBundle\Steps;

use CorahnRin\CorahnRinBundle\Controller\GeneratorController as Controller;
use CorahnRin\CorahnRinBundle\Entity\Steps;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\Translator;

/**
 * Charge les étapes pour le contrôleur, d'après un nom de fichier dépendant de l'étape injectée.
 *
 * @author  Alex "Pierstoval" <pierstoval@gmail.com>
 */
class StepLoader implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var array
     */
    private $character;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var int
     */
    private $step;

    /**
     * @var Steps[]
     */
    private $steps;

    /**
     * @var string
     */
    private $steps_managers_directory;

    /**
     * @var string
     */
    private $steps_views_directory;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var Steps
     */
    public $stepEntity;

    public function __construct($steps_managers_directory, $steps_views_directory)
    {
        $this->steps_managers_directory = $steps_managers_directory;
        $this->steps_views_directory = $steps_views_directory;
    }

    /**
     * Initialise le StepLoader avec toutes les données nécessaires aux divers managers.
     * L'injection se fait manuellement pour être sûr de palier à toute erreur liée à la durée de vie de la requête.
     * Ainsi, les paramètres comme la session et la requête correspondent toujours aux bonnes informations.
     *
     * @param Controller       $controller Le contrôleur ayant chargé le StepLoader
     * @param SessionInterface $session    La session en cours, pour récupérer le personnage
     * @param Request          $request    La requête, pour les données POST gérées par les managers
     * @param Steps            $step       L'étape en cours
     * @param array            $steps      La liste des étapes (pour éviter une nouvelle injection
     */
    public function initialize(Controller $controller, SessionInterface $session, Request $request, Steps $step, $steps)
    {
        $this->em = $this->container->get('doctrine')->getManager();
        $this->controller = $controller;
        $this->session = $session;
        $this->request = $request;
        $this->stepEntity = $step;
        $this->step = $step->getStep();
        $this->steps = $steps;
        $this->filename = $this->steps_managers_directory.'/_step_'.str_pad($step->getId(), 2, 0, STR_PAD_LEFT).'_'.$step->getSlug().'.php';
        $this->character = $session->get('character');
        $this->initialized = true;
    }

    /**
     * Vérifie que le StepLoader a été initialisé.
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function checkInitialized()
    {
        if ($this->initialized) {
            return true;
        } else {
            throw new \RuntimeException('Le StepLoader doit être initialisé avant toute action supplémentaire.<br />Voir documentation de la classe "'.__CLASS__.'".');
        }
    }

    /**
     * Vérifie si le fichier de l'étape existe.
     *
     * @return bool
     */
    public function exists()
    {
        return file_exists($this->filename);
    }

    /**
     * Récupère une étape à partir du numéro de l'étape demandée.
     *
     * @param Steps|int $step
     *
     * @return Steps
     *
     * @throws \Exception
     */
    public function getStep($step = null)
    {
        if (null === $step) {
            return $this->stepEntity;
        }
        if ($step instanceof Steps) {
            return $step;
        }
        if (is_numeric($step)) {
            if (array_key_exists($step, $this->steps)) {
                return $this->steps[$step];
            } else {
                throw new \InvalidArgumentException('Step not found in StepLoader\'s steps list.');
            }
        }

        return false;
    }

    /**
     * Renvoie la valeur de l'étape demandée dans le personnage en session.
     * Renvoie null si la clé n'existe pas.
     *
     * @param Steps|int $step
     *
     * @return mixed
     */
    public function getStepValue($step = null)
    {
        $step = $this->getStep($step);
        $stepFullName = $this->stepFullName($step);

        return array_key_exists($stepFullName, $this->character)
            ? $this->character[$stepFullName]
            : null;
    }

    /**
     * Retourne le dossier de chargement des vues liées aux managers d'étape.
     *
     * @return string
     */
    public function getViewsDirectory()
    {
        return preg_replace('~:$~Uu', '', $this->steps_views_directory);
    }

    /**
     * Retourne le nom complet de l'étape : {step}.{slug}
     * Utilisé majoritairement en session pour définir les différentes clés.
     *
     * @param Steps $step L'étape à parser. Si aucune étape n'est parsée, l'étape en cours est renvoyée
     *
     * @return string
     */
    public function stepFullName(Steps $step = null)
    {
        $step = $this->getStep($step);

        return $step->getStep().'.'.$step->getSlug();
    }

    /**
     * Affecte les données $datas au personnage à l'étape en cours, ou à l'étape demandée.
     *
     * @param mixed     $datas
     * @param Steps|int $step
     */
    public function characterSet($datas, $step = null)
    {
        $step = $this->stepFullName($step);
        $this->character[$step] = $datas;
        $this->session->set('character', $this->character);
    }

    /**
     * @param null $step
     *
     * @return $this
     */
    public function clearStep($step = null)
    {
        $step = $this->stepFullName($step);
        if (isset($this->character[$step])) {
            unset($this->character[$step]);
        }
        $this->session->set('character', $this->character);

        return $this;
    }

    /**
     * Redirige à l'étape suivante.
     *
     * @return Steps|array
     */
    public function nextStep()
    {
        return $this->controller->_goToStep($this->step + 1);
    }

    /**
     * Supprime de la session les valeurs qui dépendent de l'étape en cours.
     *
     * @return $this
     */
    public function resetSteps()
    {
        foreach ($this->stepEntity->getStepsToDisableOnChange() as $s) {
            unset($this->character[$this->stepFullName($s)]);
        }

        return $this;
    }

    /**
     * Exécute le fichier php existant et renvoie sa réponse.
     *
     * La réponse peut être un array :<br />
     *  Dans ce cas, c'est la vue twig qui sera chargée, et on enverra le tableau en guise de variables
     * Si la réponse est un objet, c'est un objet RedirectResponse<br />
     *  Dans ce cas, on redirige, soit vers l'étape suivante, soit vers une autre page
     *
     * @throws \InvalidArgumentException If steps the file does not exist.
     *
     * @return array|RedirectResponse
     */
    public function load()
    {
        if (file_exists($this->filename)) {
            $returnValue = include $this->filename;
            if ($this->request->isMethod('POST')) {
                if (is_array($returnValue)) {
                    $this
                        ->clearStep()
                        ->resetSteps()
                    ;
                } elseif (is_object($returnValue)) {
                    $this->resetSteps();
                }
            }

            return $returnValue;
        } else {
            throw new \InvalidArgumentException('File calculated by StepLoader does not exist : "'.$this->filename.'"');
        }
    }

    /**
     * Crée une erreur "flash".
     *
     * @param string $msg
     * @param string $type
     * @param array  $msgParams
     *
     * @return $this
     */
    public function flashMessage($msg, $type = 'error', array $msgParams = [])
    {
        $msg = $this->container->get('translator')->trans($msg, $msgParams, 'error.steps');
        $this->session->getFlashBag()->add($type, $msg);

        return $this;
    }
}
