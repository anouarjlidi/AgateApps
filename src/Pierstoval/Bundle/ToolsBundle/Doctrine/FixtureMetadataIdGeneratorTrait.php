<?php

namespace Pierstoval\Bundle\ToolsBundle\Doctrine;

use Doctrine\ORM\Mapping\ClassMetadata;

trait FixtureMetadataIdGeneratorTrait
{
    /**
     * {@inheritdoc}
     *
     * We override this because the generator type sometimes depends on the DBMS.
     */
    protected function setGeneratorBasedOnId(ClassMetadata $metadata, $id = null)
    {
        if ($id) {
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        } else {
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);
        }
    }
}
