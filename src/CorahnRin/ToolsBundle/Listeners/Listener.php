<?php

namespace CorahnRin\ToolsBundle\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Acme\StoreBundle\Entity\Product;

/**
 * Class Listener
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 27/01/2014
 */
class Listener {

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // Place l'attribut "deleted" à zéro au cas où il n'est pas spécifié
        if (property_exists(get_class($entity), 'deleted')) {
            if (null === $entity->getDeleted()) {
                $entity->setDeleted(0);
            }
        }
    }
}
