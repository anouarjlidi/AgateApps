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
use Behat\Transliterator\Transliterator;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PortalElementController extends AdminController
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(FilesystemInterface $oneupFlysystem)
    {
        $this->filesystem = $oneupFlysystem;
    }

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
                $imageField->addError(new FormError($translator->trans('portal_element.image.mandatory', [], 'validators')));

                return;
            }

            if ($imageField->getData() && $imageField->isValid()) {
                $newname = 'portal_element_'
                    .Transliterator::urlize(pathinfo($portalElement->image->getClientOriginalName(), PATHINFO_FILENAME))
                    .uniqid('_pe', true) // "pe" for "portal element"
                    .'.'.$portalElement->image->guessExtension()
                ;

                $stream = fopen($portalElement->image->getRealPath(), 'rb');

                $uploadResult = $this->filesystem->writeStream($newname, $stream, ['mimetype' => $portalElement->image->getMimeType()]);

                if (false === $uploadResult) {
                    $imageField->addError(new FormError($translator->trans('portal_element.image.upload_error', [], 'validators')));

                    return;
                }

                $portalElement->setImageUrl($newname);
            }
        });

        return $formBuilder;
    }
}
