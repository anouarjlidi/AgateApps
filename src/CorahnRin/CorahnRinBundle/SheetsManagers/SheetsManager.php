<?php

namespace CorahnRin\CorahnRinBundle\SheetsManagers;

use CorahnRin\CorahnRinBundle\Services\Sheets;
use CorahnRin\CorahnRinBundle\Entity\Characters;

/**
 * Class ServiceManager
 * Project corahn_rin.
 *
 * @author Pierstoval
 *
 * @version 1.0 20/02/2014
 */
abstract class SheetsManager implements SheetsManagerInterface
{
    /**
     * @var Sheets
     */
    private $service;
    private $locale;

    public function __construct(Sheets $service)
    {
        $this->service = $service;
        $this->locale = $service->getTranslator()->getLocale();
        $this->folder = $service->getFolder();
    }

    /**
     * Exécute la fonction utilisateur du SheetsManager qui crée une (ou plusieurs) feuille(s) de personnage.<br />
     * Le format est le suivant :<br />
     *  {type}_{locale}_{page}_{printerFriendly}_{extension}<br />
     * L'extension et la locale sont automatiquement récupérée depuis le traducteur injecté.
     *
     * @param \CorahnRin\CorahnRinBundle\Entity\Characters $character
     * @param string                                       $type             Le type de feuille
     * @param bool                                         $printer_friendly
     * @param int                                          $page
     *
     * @throws \Exception
     */
    public function generateSheet(Characters $character, $type = 'original', $printer_friendly = false, $page = 0)
    {
        $method_name = $type.'Sheet';

        if (method_exists($this, $method_name)) {
            return $this->$method_name($character, $printer_friendly, $page);
        } else {
            throw new \Exception('La méthode "'.$type.'Sheet" n\'existe pas dans la classe "'.__CLASS__.'".');
        }
    }

    /**
     * Renvoie le SheetsService.
     *
     * @return Sheets
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Retourne le gestionnaire de feuille de personnage du type demandé.
     *
     * @param string $type
     *
     * @return SheetsManager
     */
    public function getManager($type)
    {
        return $this->service->getManager($type);
    }

    /**
     * Retourne le chemin complet du dossier des feuilles de personnage source.
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Renvoie la locale actuelle.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Convertit un chemin relatif à un bundle en un chemin absolu (via le kernel).
     *
     * @param string $resource
     * @param string $dir
     * @param bool   $first
     *
     * @return string
     */
    public function locateResource($resource, $dir = null, $first = true)
    {
        return $this->service->locateResource($resource, $dir, $first);
    }
}
