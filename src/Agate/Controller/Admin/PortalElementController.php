<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Controller\Admin;

use Admin\Controller\AdminController;
use Agate\Entity\PortalElement;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PortalElementController extends AdminController
{
    public function createPortalElementEntityFormBuilder(PortalElement $portalElement, string $view): FormBuilderInterface
    {
        $formBuilder = parent::createEntityFormBuilder($portalElement, $view);

        if ($view === 'new') {
            $formBuilder->get('image')->setRequired(true);
        }

        $translator = $this->get('translator');

        $formBuilder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($translator) {
            /** @var PortalElement $portalElement */
            $portalElement = $event->getData();

            $imageField = $event->getForm()->get('image');

            if (!$portalElement->image && !$portalElement->getImageUrl()) {
                $imageField->addError(new FormError($translator->trans('This value should not be blank.', [], 'validators')));

                return;
            }

            if ($imageField->isValid()) {
                // Todo: upload the file
                dump($portalElement);
                exit;
            }
        });

        return $formBuilder;
    }
}
