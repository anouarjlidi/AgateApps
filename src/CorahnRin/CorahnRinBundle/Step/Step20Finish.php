<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Step;

use CorahnRin\CorahnRinBundle\Exception\CharactersException;
use CorahnRin\CorahnRinBundle\GeneratorTools\SessionToCharacter;

class Step20Finish extends AbstractStepAction
{
    /**
     * @var SessionToCharacter
     */
    private $sessionToCharacter;

    public function __construct(SessionToCharacter $sessionToCharacter)
    {
        $this->sessionToCharacter = $sessionToCharacter;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->updateCharacterStep([]);

        $character = null;

        try {
            $character = $this->sessionToCharacter->createCharacterFromGeneratorValues($this->getCurrentCharacter());
        } catch (CharactersException $e) {
            $this->flashMessage('errors.character_not_complete');
            $this->goToStep(1);
        }

        return $this->renderCurrentStep([
            'character' => $character,
            'serialized_character' => json_encode($this->getCurrentCharacter(), 480),
        ]);
    }
}
