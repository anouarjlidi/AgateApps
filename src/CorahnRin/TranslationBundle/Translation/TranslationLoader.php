<?php

namespace CorahnRin\TranslationBundle\Translation;

use Symfony\Component\Translation\Loader\LoaderInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class TranslationLoader
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 22/03/2014
 */
class TranslationLoader implements LoaderInterface {

    /**
     * @var CorahnRin\TranslationBundle\Repository\TranslationRepository
     */
    private $transRepo;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager){
        $this->transRepo = $entityManager->getRepository("CorahnRinTranslationBundle:Translation");
//        $this->langRepo = $entityManager->getRepository("CorahnRinTranslationBundle:Languages");
    }

    function load($resource, $locale, $domain = 'messages'){

        $translations = $this->transRepo->findBy(array('locale' => $locale, 'domain' => $domain));

        $catalogue = new MessageCatalogue($locale);

        foreach($translations as $translation){
            $catalogue->set($translation->getSource(), $translation->getTranslation(), $domain);
        }

        return $catalogue;
    }

}
