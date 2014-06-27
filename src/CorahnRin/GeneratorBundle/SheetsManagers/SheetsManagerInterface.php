<?php

namespace CorahnRin\GeneratorBundle\SheetsManagers;

use CorahnRin\ModelsBundle\Entity\Characters;
use CorahnRin\GeneratorBundle\Services\Sheets;

/**
 * Interface ManagerInterface
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 20/02/2014
 */
interface SheetsManagerInterface {

    function __construct(Sheets $manager);

    function generateSheet(Characters $character, $type, $printer_friendly, $page);

}
