<?php

namespace CorahnRin\GeneratorBundle\Sheets;

use CorahnRin\CharactersBundle\Entity\Characters;
use CorahnRin\GeneratorBundle\Sheets\SheetsService;

/**
 * Interface ManagerInterface
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 20/02/2014
 */
interface ManagerInterface {

    function __construct(SheetsService $manager);

    function generateSheet(Characters $character, $type, $printer_friendly, $page);

}
